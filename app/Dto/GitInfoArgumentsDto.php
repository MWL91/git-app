<?php

namespace App\Dto;

use App\Exceptions\DataException;

class GitInfoArgumentsDto
{
    /**
     * @var string
     */
    private $owner;
    
    /**
     * @var string
     */
    private $repo;
    
    /**
     * @var string
     */
    private $branch;
    
    /**
     * @var string
     */
    private $service;

    /**
     * GitInfoArgumentsDto constructor
     *
     * @param array $arguments
     * @param array $options
     */
    public function __construct(array $arguments, array $options)
    {
        $ownerRepo = explode('/', $arguments['owner/repo']);
        if(sizeof($ownerRepo) !== 2) {
            throw new DataException('Wrong owner/repo parameter');
        }

        list($this->owner, $this->repo) = $ownerRepo;
        $this->branch = $arguments['branch'] ?? config('gitinfo.defaults.branch');
        $this->service = $options['service'] ?? config('gitinfo.defaults.service');
    }

    /**
     * @return string
     */
    public function getOwner(): string
    {
        return $this->owner;
    }

    /**
     * @return string
     */
    public function getRepo(): string
    {
        return $this->repo;
    }

    /**
     * @return string
     */
    public function getBranch(): string
    {
        return $this->branch;
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    
}