<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    public function creator()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function assignedTo()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function status()
    {
        return $this->belongsTo('App\TaskStatus');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
