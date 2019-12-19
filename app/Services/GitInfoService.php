<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Dto\GitInfoArgumentsDto;
use App\Exceptions\GitInfoException;
use App\Contracts\GitInfoServiceContract;
use GuzzleHttp\Exception\ClientException;
use App\Services\Strategies\GitInfoStrategyInterface;

class GitInfoService implements GitInfoServiceContract
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var GitInfoArgumentsDto
     */
    private $arguments = null;

    /**
     * GitInfoService contract
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Set arguments to fetch data
     * 
     * @param GitInfoArgumentsDto $arguments
     * 
     * @return void
     */
    public function setArguments(GitInfoArgumentsDto $arguments): void
    {
        $this->arguments = $arguments;
    }

    /**
     * @return string
     */
    public function getSha(): string
    {
        if(is_null($this->arguments)) {
            throw new GitInfoException('You have to add arguments for the request');
        }

        $serviceStrategy = $this->getStrategy();

        try {
            $serviceStrategy->getRefs();
            return $serviceStrategy->getSha();
        } catch (ClientException $e) {
            $errorBody = $e->getResponse()->getBody()->getContents();
            throw new GitInfoException($serviceStrategy->getExceptionMessage($errorBody));
        }
        
    }

    /**
     * @return GitInfoStrategyInterface
     */
    private function getStrategy(): GitInfoStrategyInterface
    {
        $service = $this->arguments->getService();
        $strategyClassName = 'App\\Services\\Strategies\\'.ucfirst($service);

        if(!class_exists($strategyClassName)) {
            throw new GitInfoException("Unknown service '$service'");
        }

        return new $strategyClassName($this->arguments, $this->client);
    }

}