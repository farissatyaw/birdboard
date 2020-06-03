<?php

namespace Tests\Setup;

use App\Project;

class ProjectFactory
{
    protected $tasksCount;
    protected $user;

    public function withTasks($count)
    {
        $this->tasksCount=$count;
        return $this;
    }
    public function create()
    {
        $project = factory('App\Project')->create([
            'user_id'=>$this->user ?? factory('App\User')
        ]);
        factory('App\Task', $this->tasksCount)->create([
            'project_id'=>$project->id
        ]);
        return $project;
    }
    public function ownedBy($user)
    {
        $this->user=$user;
        return $this;
    }
}
