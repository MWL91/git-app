<?php

namespace App\Services\Strategies;

use GuzzleHttp\Client;
use App\Dto\GitInfoArgumentsDto;
use Illuminate\Support\Collection;

interface GitInfoStrategyInterface
{
    
    /**
     * @param GitInfoArgumentsDto $arguments
     */
    public function __construct(GitInfoArgumentsDto $arguments, Client $client);

    /**
     * @return Collection
     */
    public function getRefs(): Collection;

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