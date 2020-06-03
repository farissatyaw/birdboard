<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function modelPath()
    {
        $project= factory('App\Project')->create();
        $project->path();
        $this->assertEquals('/projects/'.$project->id, $project->path());
    }
    /** @test */
    public function itCanAddTask()
    {
        $project= factory('App\Project')->create();
        $task= $project->addTask('Test Task');
        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }
}
