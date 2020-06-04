<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Activity;

class Task extends Model
{
    protected $guarded=[];
    protected $touches = ['project'];
    protected $casts = [
        'completed' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($task) {
            $task->recordActivity('created_task');
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function path()
    {
        return "/projects/{$this->project->id}/tasks/$this->id";
    }
    public function complete($status=null)
    {
        $this->update(['completed'=>isset($status) ? false : true]);
        $this->recordActivity(isset($status) ? "uncompleted":"completed");
    }
    public function incomplete()
    {
        $this->complete(false);
    }
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }
    public function recordActivity($description)
    {
        $this->activity()->create([
            'project_id'=>$this->project->id,
            'description'=>$description
        ]);
    }
}
