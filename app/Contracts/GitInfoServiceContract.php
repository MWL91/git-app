<?php

namespace App\Contracts;

use App\Dto\GitInfoArgumentsDto;

interface GitInfoServiceContract
{
    public function setArguments(GitInfoArgumentsDto $arguments): void;
    
    public function getSha(): string;
}