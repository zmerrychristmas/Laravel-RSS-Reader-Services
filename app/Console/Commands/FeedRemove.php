<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Feed;
use Config;

class FeedRemove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:remove {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove Feed of User default id 1, param is ID or URL';

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
        if (is_numeric($this->argument('id'))) {
            $feed = Feed::where('user_id', '=', Config::get('default_user_id', 1))
                            ->where('id', '=', $this->argument('id'))
                            ->delete();
        } else {
            $feed = Feed::where('user_id', '=', Config::get('default_user_id', 1))
                            ->where('url', '=', $this->argument('id'))
                            ->delete();
        }
    }
}
