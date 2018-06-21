<?php

namespace App;
use Cache, Config;

class RssReader
{
    public function parseRss($url)
    {
        $xml = $this->loadRss($url);
        $entries = simplexml_load_string($xml);
        $entries = $entries->xpath("//item");
        //Sort feed entries by pubDate
        usort($entries, function ($feed1, $feed2) {
            return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
        });
        return $entries;
    }

    protected function loadRss($url)
    {
        $result = '';
        if (Cache::has($url)) {
            $result = Cache::get($url);
        } else {
            $result = simplexml_load_file($url);
            $result = $result->asXML();
            $expirated = now()->addMinutes(Config::get('blog_feed.expirated', 3));
            Cache::add($url, $result, $expirated);
        }
        return $result;
    }
}