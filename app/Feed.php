<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'user_id', 'title',
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_feeds')->withTimestamps();
    }
    public function clearCategories()
    {
        foreach($this->categories as $cat)
        {
            $this->categories()->detach($cat);
        }
    }
    public function assignCategories($cat)
    {
        return $this->categories()->attach($cat);
    }

}
