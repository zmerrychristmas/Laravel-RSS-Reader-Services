<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'user_id'
    ];
    public function feeds()
    {
        return $this->belongsToMany('App\Feed', 'category_feeds')->withTimestamps();
    }

    public function hasFeed($name, $order = false)
    {

        foreach($this->feeds as $feed_entry)
        {
            if($feed_entry->url == $name) return true;
        }
        return false;
    }

    public function assignFeed($feed)
    {
        return $this->feeds()->attach($feed);
    }

    public function removeFeed($feed)
    {
        return $this->feeds()->detach($feed);
    }

    public function clearFeed()
    {
        foreach($this->feeds as $feed)
        {
            $this->feeds()->detach($feed);
        }
    }
}
