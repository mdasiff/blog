<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'slug', 'title', 'description', 'image'];

    /*public function getImageAttribute()
    {
    	return asset('images/'.$this->image);
    }*/

    public function user()
    {
    	return $this->belongsTo('App\Models\User');
    }
    public function parent_comments()
    {
    	return $this->hasMany('App\Models\Comment')->whereParentId(0)->latest();
    }
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Like');
    }
}
