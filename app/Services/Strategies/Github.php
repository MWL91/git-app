<?php

namespace App\Services\Strategies;

use GuzzleHttp\Client;
use App\Dto\GitInfoArgumentsDto;
use App\Exceptions\GitInfoException;
use Illuminate\Support\Collection;
use stdClass;

class Github implements GitInfoStrategyInterface
{
    /**
     * @var GitInfoArgumentsDto
     */
    private $arguments;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var Collection
     */
    private $refs;
    
    /**
     * GithubStrategy constructor
     *
     * @param GitInfoArgumentsDto $arguments
     */
    public function __construct(GitInfoArgumentsDto $arguments, Client $client)
    {
        $this->arguments = $arguments;
        $this->client = $client;
    }

    /**
     * @return Collection
     */
    public function getRefs(): Collection
    {
        $request = $this->client->request('GET', 'https://api.github.com/repos/'.$this->arguments->getOwner().'/'.$this->arguments->getRepo().'/git/refs');
        
        $contents = json_decode($request->getBody()->getContents());

        $this->refs = collect($contents);
        return $this->refs;
    }

    /**
     * @return string
     */
    public function getSha(): string
    {
        return $this->getLastRefByBranch()->object->sha;
    }

    /**
     * @param string $responseContents
     * 
     * @return string
     */
    public function getExceptionMessage(string $responseContents): string
    {
        $responseContents = json_decode($responseContents);
        return "Error on getting data from github API: '{$responseContents->message}'";
    }

    /**
     * @return stdClass
     */
    private function getLastRefByBranch(): stdClass
    {
        return $this->refs->where('ref', 'refs/heads/'.$this->arguments->getBranch())->first();
    }
    
}