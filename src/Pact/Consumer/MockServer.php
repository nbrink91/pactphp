<?php

namespace Pact\Consumer;

use Exception;
use GuzzleHttp\Exception\ConnectException;
use Pact\Consumer\Http\GuzzleClient;
use Pact\Consumer\Service\MockServerHttpService;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class MockServer
{
    /** @var MockServerConfig */
    private $config;

    /** @var Process */
    private $process;

    public function __construct(MockServerConfig $config)
    {
        $this->config = $config;
    }

    /**
     * Build a key value array of parameter to value.
     * @return array
     */
    private function buildParameters(): array
    {
        $results = [];

        if ($this->config->getConsumer() !== null) {
            $results['consumer'] = $this->config->getConsumer();
        }

        if ($this->config->getProvider() !== null) {
            $results['provider'] = $this->config->getProvider();
        }

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
     * @return string
     */
    private function buildCommand(): string
    {
        $command = __DIR__ . '/../../../pact/bin/pact-mock-service service';

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
        $command = $this->buildCommand();
        echo "Starting the Mock Server with command: {$command}...\r\n";

        $this->process = new Process($command);
        $this->process->start();

        if ($this->process->isRunning() !== true) {
            throw new ProcessFailedException($this->process);
        }

        $service = new MockServerHttpService(new GuzzleClient(), $this->config);

        // Verify that the service is up.
        $tries = 0;
        do {
            sleep(1);
            $tries++;
            try {
                $connected = $service->healthcheck();
            } catch (ConnectException $e) {
                $connected = false;
            }
        } while ($connected === false && $tries <= 10);

        return $this->process->getPid();
    }

    /**
     * Stop the Mock Server process.
     * @return bool Did the Mock Server process stop correctly?
     * @throws Exception
     */
    public function stop(): bool
    {
        $result = $this->process->stop();

        if ($result === false) {
            throw new ProcessFailedException($this->process);
        }

        return $result;
    }
}