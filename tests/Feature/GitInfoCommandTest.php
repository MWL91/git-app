<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Exceptions\GitInfoException;

class GitInfoCommandTest extends TestCase
{
    /**
     * Test Git Info Command normal usage
     *
     * @return void
     */
    public function testGitInfoCommand()
    {
        $this->artisan('gitinfo MWL91/git-app')
             ->assertExitCode(0);
    }

    /**
     * Test Git Info Command wrong repository
     *
     * @return void
     */
    public function testIsGitInfoCommandFailedOnNonExistingRepository()
    {
        $this->artisan('gitinfo MWL91/non-exist')
             ->expectsOutput("Error on getting data from github API: 'Not Found'")
             ->assertExitCode(0);
    }

    /**
     * Test Git Info Command wrong provider
     *
     * @return void
     */
    public function testIsGitInfoCommandFailedOnWrongProvider()
    {
        $this->artisan('gitinfo MWL91/git-app --service=nonexist')
             ->expectsOutput("Unknown service 'nonexist'")
             ->assertExitCode(0);
    }
}
