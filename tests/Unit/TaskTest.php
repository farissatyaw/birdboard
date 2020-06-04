<?php

namespace Tests\Unit;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function hasPath()
    {
        $task=factory('App\Task')->create();
        $this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }
    /** @test */
    public function belongsToProject()
    {
        $task=factory('App\Task')->create();
        $this->assertInstanceOf('App\Project', $task->project);
    }
    /** @test */
    public function completeStatusTrue()
    {
        $task=factory('App\Task')->create();
        $task->complete();
        $this->assertTrue($task->fresh()->completed);
    }
}
