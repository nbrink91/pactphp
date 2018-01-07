<?php

namespace Pact\Consumer;

use Exception;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Uri;
use Pact\Consumer\Http\GuzzleClient;
use Pact\Consumer\Service\MockServerHttpService;
use Pact\Consumer\Service\RubyStandaloneBinaryManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use ZipArchive;

class MockServer
{
    /** @var MockServerConfig */
    private $config;

    /** @var RubyStandaloneBinaryManager */
    private $binaryManager;

    /** @var Process */
    private $process;

    /** @var Filesystem */
    private $fileSystem;

    public function __construct(MockServerConfig $config, RubyStandaloneBinaryManager $binaryManager)
    {
        $this->config = $config;
        $this->binaryManager = $binaryManager;
        $this->fileSystem = new Filesystem();
    }

    /**
     * Build a key value array of parameter to value.
     * @return array
     */
    private function buildParameters(): array
    {
        $results = [];

        $results['consumer'] = $this->config->getConsumer();
        $results['provider'] = $this->config->getProvider();

        if ($this->config->getHost() !== null) {
            $results['host'] = $this->config->getHost();
        }

        if ($this->config->getPort() !== null) {
            $results['port'] = $this->config->getPort();
        }

        if ($this->config->getPactDir() !== null) {
            $results['pact-dir'] = $this->config->getPactDir();
        }

        if ($this->config->getPactFileWriteMode() !== null) {
            $results['pact-file-write-mode'] = $this->config->getPactFileWriteMode();
        }

        if ($this->config->getPactSpecificationVersion() !== null) {
            $results['pact-specification-version'] = $this->config->getPactSpecificationVersion();
        }

        if ($this->config->getLog() !== null) {
            $results['log'] = $this->config->getLog();
        }

        return $results;
    }

    /**
     * Put everything together into a single command line script.
     * @param string $binaryPath Path to mock server service binary.
     * @return string
     */
    private function buildCommand(string $binaryPath): string
    {
        $command = "{$binaryPath} service";

        foreach ($this->buildParameters() as $name => $value)
        {
            $command .= " --{$name}=\"{$value}\"";
        }

        return $command;
    }

    /**
     * Start the Mock Server. Verify that it is running.
     * @return int Process ID of the started Mock Server.
     * @throws Exception
     */
    public function start(): int
    {
        $scripts = $this->binaryManager->install();

        $command = $this->buildCommand($scripts->getMockService());
        echo "Starting the Mock Server with command: {$command}...\r\n";

        $this->process = new Process($command);
        $this->process->start();

        if ($this->process->isRunning() !== true) {
            throw new ProcessFailedException($this->process);
        }

        $this->verifyHealthCheck();

        return $this->process->getPid();
    }

    /**
     * Stop the Mock Server process.
     * @return bool Did the Mock Server process stop correctly?
     * @throws Exception
     */
    public function stop(): bool
    {
        if ($this->process instanceof Process) {
            $result = $this->process->stop();

            if ($result !== 1) {
                throw new ProcessFailedException($this->process);
            }
        }

        return true;
    }

    /**
     * Make sure the server starts as expected.
     * @return bool
     * @throws Exception
     */
    private function verifyHealthCheck(): bool
    {
        $service = new MockServerHttpService(new GuzzleClient(), $this->config);

        // Verify that the service is up.
        $tries = 0;
        do {
            $tries++;
            echo "Attempting try {$tries} to connect to Mock Server.\n";
            sleep(1);

            try {
                $status = $service->healthCheck();
                echo "Successfully connected.\n";
                return $status;
            } catch (ConnectException $e) {
                echo "Failed to connect.\n";
            }
        } while ($tries <= 10);

        throw new Exception('Health Check failed for Mock Server.');
    }
}
