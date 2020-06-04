<?php

namespace App;

trait RecordsActivity
{
    public static function bootRecordsActivity()
    {
        foreach (self::recordableEvents() as $events) {
            static::$events(function ($model) use ($events) {
                $description = $events;
                $description = "{$events}_" . strtolower(class_basename($model));
                $model->recordActivity($description);
            });
        }
    }
    public function recordActivity($description)
    {
        $this->activity()->create([
            'user_id'=>$this->activityUser()->id,
            'project_id'=>class_basename($this)=== 'Project' ? $this->id : $this->project->id,
            'description'=>$description
        ]);
    }
    protected function activityUser()
    {
        if (auth()->check()) {
            return auth()->user();
        }
        $project=$this->project ?? $this;
        return $project->user;
    }
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }
    protected static function recordableEvents()
    {
        if (isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        } else {
            return ['created', 'updated'];
        }
    }
}
