<?php

namespace Tests\Unit\Services;

use Mockery;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use App\Dto\GitInfoArgumentsDto;
use App\Services\GitInfoService;
use App\Exceptions\DataException;
use App\Exceptions\GitInfoException;
use GuzzleHttp\Exception\ClientException;

class GitInfoServiceTest extends TestCase
{
    /**
     * @var GitInfoService
     */
    public $gitInfoService;

    /**
     * @var GitInfoArgumentsDto
     */
    public $gitInfoArgumentsDto;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $json = '[
            {
            "ref": "refs/heads/master",
            "node_id": "MDM6UmVmMjI5MDU1OTExOm1hc3Rlcg==",
            "url": "https://api.github.com/repos/MWL91/git-app/git/refs/heads/master",
            "object": {
                "sha": "ee3ebef5e1ea7408e72ff07ed1e2483865bb278f",
                "type": "commit",
                "url": "https://api.github.com/repos/MWL91/git-app/git/commits/ee3ebef5e1ea7408e72ff07ed1e2483865bb278f"
            }
            }
        ]';

        $getContentsMockery = Mockery::mock(Client::class)
            ->shouldReceive('getContents')
            ->withAnyArgs()
            ->andReturn($json)
            ->getMock();

        $bodyMockery = Mockery::mock(Client::class)
            ->shouldReceive('getBody')
            ->withAnyArgs()
            ->andReturn($getContentsMockery)
            ->getMock();

        $clientMock = Mockery::mock(Client::class)
            ->shouldReceive('request')
            ->withAnyArgs()
            ->andReturn($bodyMockery)
            ->getMock();

        $this->gitInfoService = new GitInfoService($clientMock);

        $this->gitInfoArgumentsDto = new GitInfoArgumentsDto(
            [
                'owner/repo' => 'MWL91/git-app', 
                'branch' => 'master'
            ], 
            [
                'service' => 'github'
            ]
        );
    }

    /**
     * @test
     * @return void
     */
    public function testGetSha()
    {
        $this->gitInfoService->setArguments($this->gitInfoArgumentsDto);
        $this->assertNotEmpty($this->gitInfoService->getSha());
    }

    /**
     * @test
     * @return void
     */
    public function testGetShaNoArgs()
    {
        $this->expectException(GitInfoException::class);
        $this->gitInfoService->getSha();
    }

    /**
     * @test
     * @return void
     */
    public function testNonExistingStategy()
    {
        $this->gitInfoArgumentsDto = new GitInfoArgumentsDto(
            [
                'owner/repo' => 'MWL91/nonexists', 
                'branch' => 'master'
            ], 
            [
                'service' => 'nonexist'
            ]
        );

        $this->expectException(GitInfoException::class);
        $this->gitInfoService->setArguments($this->gitInfoArgumentsDto);
        $this->gitInfoService->getSha();
    }

    public function testWrongInput()
    {
        $this->expectException(DataException::class);
        
        $this->gitInfoArgumentsDto = new GitInfoArgumentsDto(
            [
                'owner/repo' => 'MWL91', 
                'branch' => 'master'
            ], 
            [
                'service' => 'nonexist'
            ]
        );
    }
}
