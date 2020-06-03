<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function projectHaveTask()
    {
        $project=ProjectFactory::create();
        $this->actingAs($project->user)
            ->post($project->path() . '/tasks', ['body' => 'Test Task']);

        $this->get($project->path())->assertSee('Test Task');
    }
    /** @test */
    public function taskRequiresBody()
    {
        $project=ProjectFactory::create();
        $attributes=factory('App\Task')->raw(['body'=>'']);
        $this->actingAs($project->user)
            ->post($project->path() . '/tasks', $attributes) ->assertSessionHasErrors('body');
    }
    /** @test */
    public function onlyTheOwnerCanAddTask()
    {
        $this->signIn();
        $project=factory('App\Project')->create();
        $this->post($project->path() . '/tasks', ['body' => 'Test Task'])->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body'=>'Test Task']);
    }
    /** @test */
    public function canUpdateTask()
    {
        $project=ProjectFactory::withTasks(2)->create();
        $this->be($project->user)
            ->post($project->tasks->first()->path(), [
            'body' => 'Changed',
            'completed' => true
        ]);
        
        $this->assertDatabaseHas('tasks', [
            'body'=> 'Changed',
            'completed' => true
        ]);
    }
    /** @test */
    public function onlyTheOwnerCanUpdateTask()
    {
        $this->signIn();
        $project=ProjectFactory::withTasks(1)->create();
        $this->post($project->tasks->first()->path(), ['body' => 'Changed'])->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body'=>'Changed']);
    }
}
