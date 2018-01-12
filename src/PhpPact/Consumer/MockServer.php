<?php

namespace PhpPact\Consumer;

use Exception;
use GuzzleHttp\Exception\ConnectException;
use PhpPact\Consumer\Exception\HealthCheckFailedException;
use PhpPact\Consumer\Service\MockServerHttpService;
use PhpPact\Core\BinaryManager\BinaryManager;
use PhpPact\Core\Http\GuzzleClient;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class MockServer
{
    /** @var MockServerConfig */
    private $config;

    /** @var BinaryManager */
    private $binaryManager;

    /** @var Process */
    private $process;

    /** @var Filesystem */
    private $fileSystem;

    public function __construct(MockServerConfig $config, BinaryManager $binaryManager)
    {
        $this->config        = $config;
        $this->binaryManager = $binaryManager;
        $this->fileSystem    = new Filesystem();
    }

    /**
     * Start the Mock Server. Verify that it is running.
     *
     * @throws Exception
     *
     * @return int process ID of the started Mock Server
     */
    public function start(): int
    {
        $scripts = $this->binaryManager->install();

        $command = $this->buildCommand($scripts->getMockService());

        echo 'Executing command: ' . $command;

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
     *
     * @throws Exception
     *
     * @return bool Did the Mock Server process stop correctly?
     */
    public function stop(): bool
    {
        if ($this->process instanceof Process) {
            $this->process->stop();
        }

        return true;
    }

    /**
     * Build a key value array of parameter to value.
     *
     * @return array
     */
    private function buildParameters(): array
    {
        $results = [];

        $results['consumer']             = $this->config->getConsumer();
        $results['provider']             = $this->config->getProvider();
        $results['pact-dir']             = $this->config->getPactDir();
        $results['pact-file-write-mode'] = $this->config->getPactFileWriteMode();
        $results['host']                 = $this->config->getHost();
        $results['port']                 = $this->config->getPort();

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
     *
     * @param string $binaryPath path to mock server service binary
     *
     * @return string
     */
    private function buildCommand(string $binaryPath): string
    {
        $command = "{$binaryPath} service";

        foreach ($this->buildParameters() as $name => $value) {
            $command .= " --{$name}=\"{$value}\"";
        }

        return $command;
    }

    /**
     * Make sure the server starts as expected.
     *
     * @throws Exception
     *
     * @return bool
     */
    private function verifyHealthCheck(): bool
    {
        $service = new MockServerHttpService(new GuzzleClient(), $this->config);

        // Verify that the service is up.
        $tries    = 0;
        $maxTries = 10;
        do {
            $tries++;
            \sleep(1);

            try {
                $status = $service->healthCheck();

                return $status;
            } catch (ConnectException $e) {
            }
        } while ($tries <= $maxTries);

        throw new HealthCheckFailedException("Failed to make connection to Mock Server in {$maxTries} attempts.");
    }
}
