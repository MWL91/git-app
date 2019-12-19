<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Dto\GitInfoArgumentsDto;
use App\Contracts\GitInfoServiceContract;

class GitInfoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gitinfo {owner/repo : Repository owner and name} {branch? : Repository branch name} {--service=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for get last sha code from specific repository';

    /**
     * @var GitInfoServiceContract
     */
    private $gitInfoService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GitInfoServiceContract $gitInfoService)
    {
        parent::__construct();

        $this->gitInfoService = $gitInfoService;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        try {

            $argumentsDto = new GitInfoArgumentsDto($this->arguments(), $this->options());
            $this->gitInfoService->setArguments($argumentsDto);
            $this->info($this->gitInfoService->getSha());
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        
        return;
    }
}
