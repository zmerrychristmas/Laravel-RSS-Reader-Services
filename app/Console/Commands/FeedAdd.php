<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\RssReader as RssReader;
use App\Feed;
use Config;

class FeedAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:add {url} {--title=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'feed:reed {url} {--title}';

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
        $data = [
            'url' => $this->argument('url'),
            'title' => $this->input->getOption('title') ?? '',
            'user_id' => Config::get('default_user_id', 1)
        ];
        Feed::create($data);
    }

    protected function getOptions()
    {
        return [
            ['title', null, InputOption::VALUE_OPTIONAL, 'Title'],
        ];
    }
}
