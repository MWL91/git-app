<?php

namespace App\Services\Strategies;

use GuzzleHttp\Client;
use App\Dto\GitInfoArgumentsDto;

interface GitInfoStrategyInterface
{
    
    /**
     * @param GitInfoArgumentsDto $arguments
     */
    public function __construct(GitInfoArgumentsDto $arguments, Client $client);

    /**
     * @return string
     */
    public function getSha(): string;

    /**
     * @param string $responseContents
     * 
     * @return string
     */
    public function getExceptionMessage(string $responseContents): string;

}