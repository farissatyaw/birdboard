<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded=[];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($project) {
            $project->recordActivity('created_project');
        });
        static::updated(function ($project) {
            $project->recordActivity('updated_project');
        });
    }
    // Bisa di web.php, bisa buat observer, ato bisa buat trait baru.


    public function path()
    {
        return "/projects/{$this->id}";
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }
    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }
    public function recordActivity($description)
    {
        $this->activity()->create(compact('description'));
    }
}
