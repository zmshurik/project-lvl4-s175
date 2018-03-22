<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    public function scopeCreatedByAuthUser($query, $field)
    {
        if ($field) {
            return $query->where('creator_id', Auth::id());
        }
        return $query;
    }

    public function scopeWithStatus($query, $statusId)
    {
        if ($statusId) {
            return $query->where('status_id', $statusId);
        }
        return $query;
    }

    public function scopeAssignedToUser($query, $userId)
    {
        if ($userId) {
            return $query->where('assigned_to_id', $userId);
        }
        return $query;
    }

    public function scopeWithTag($query, $tagId)
    {
        if ($tagId) {
            return $query->whereHas('tags', function ($query) use ($tagId) {
                $query->where('tag_id', $tagId);
            });
        }
        return $query;
    }

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
