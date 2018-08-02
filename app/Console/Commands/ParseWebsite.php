<?php

namespace App\Console\Commands;

use App\Jobs\ParseWebsiteJob;
use Illuminate\Console\Command;

class ParseWebsite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:website';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse website';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dispatch_now(new ParseWebsiteJob());
    }
}
