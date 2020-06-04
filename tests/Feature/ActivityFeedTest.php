<?php

namespace Tests\Feature;

use App\Task;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function createProjectGeneratesActivityFeed()
    {
        //$this->withoutExceptionHandling();
        $project=ProjectFactory::create();
        //dd($project->activity);
        $this->assertCount(1, $project->activity);
        //$this->assertEquals('created', $project->activity[0]->description);
    }
    /** @test */
    public function updateProjectGeneratesActivityFeed()
    {
        $project=ProjectFactory::create();
        $project->update(['tittle'=>'Changed']);
        $this->assertCount(2, $project->activity);
    }
    /** @test */
    public function createNewTaskGeneratesActivity()
    {
        $this->withoutExceptionHandling();
        $project=ProjectFactory::withTasks(1)->create();
        
        $this->assertCount(2, $project->activity);
        
        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }
    /** @test */
    public function completingTaskGeneratesActivity()
    {
        $project=ProjectFactory::withTasks(1)->create();
        $this->actingAs($project->user)
        ->post($project->tasks[0]->path(), [

            'body'=>'Completed',
            'completed'=>true
        ]);
        $this->assertCount(3, $project->activity);
        tap($project->activity->last(), function ($activity) {
            //dd($activity);
            $this->assertEquals('completed', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }
    /** @test */
    public function incompletingTaskGeneratesActivity()
    {
        $project=ProjectFactory::withTasks(1)->create();
        $this->actingAs($project->user)
        ->post($project->tasks[0]->path(), [

            'body'=>'Completed',
            'completed'=>true
        ]);
        $this->actingAs($project->user)
        ->post($project->tasks[0]->path(), [

            'body'=>'Completed',
            'completed'=>false
        ]);
        $this->assertCount(4, $project->activity);
        //dd($project->activity);
        $this->assertEquals('uncompleted', $project->activity->last()->description);
    }
}
