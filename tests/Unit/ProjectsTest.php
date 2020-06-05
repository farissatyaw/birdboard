<?php

namespace Tests\Unit;

use App\User;
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
    /** @test */
    public function itCanInviteUser()
    {
        $project= factory('App\Project')->create();
        $project->invite($user = factory(User::class)->create());

        $this->assertTrue($project->members->contains($user));
    }
}
