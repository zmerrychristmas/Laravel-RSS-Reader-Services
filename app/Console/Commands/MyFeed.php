<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Feed;
use App\User;
use App\RssReader as RssReader;

class MyFeed extends Command
{
    protected $reader;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all feed regitered of user have id 1';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(RssReader $reader)
    {
        $this->reader = $reader;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = User::find(1);
        if ($user) {
            $feeds= Feed::where('user_id', '=', 1)->get(['id', 'title', 'url']);
            $headers = ['ID', 'TITLE', 'URL'];
            $this->table($headers, $feeds);
        }
    }
}
