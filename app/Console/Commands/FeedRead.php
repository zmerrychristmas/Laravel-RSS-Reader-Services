<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Feed;
use App\RssReader as RssReader;
use Config;

class FeedRead extends Command
{
    protected $reader;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:read {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $url = $this->argument('id');
        if (is_numeric($this->argument('id'))) {

            $feed = Feed::where('user_id', '=', Config::get('default_user_id', 1))
                            ->where('id', '=', $this->argument('id'))
                            ->first();
            if ($feed) {
                $url = $feed->url;
            }
        }
        $content = $this->reader->parseRss($url);
        $result = [];
        foreach ($content as $key => $value) {
            $result[] = [$value->title, $value->pubDate];
        }
        $headers = ['TITLE', 'PUBDATE'];
        $this->table($headers, $result);
    }
}
