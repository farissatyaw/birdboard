<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    /** @test */
    public function guestCannotManageProject()
    {
        $project=factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('/login');
        $this->get('/projects/create')->assertRedirect('/login');
        $this->post('/projects', $project->toArray())->assertRedirect('/login');
        $this->get($project->path())->assertRedirect('/login');
    }
    /** @test */
    public function CreateProject()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory('App\User')->create());
        $this->get('/projects/create')->assertStatus(200);
        $attributes=[
            'tittle'=>$this->faker->sentence,
            'description'=>$this->faker->paragraph
        ];
        $this->post('/projects', $attributes)->assertRedirect('/projects');
        $this->assertDatabaseHas('projects', $attributes);
        $this->get('/projects')->assertSee($attributes['tittle']);
    }
    /** @test */
    public function validateTittle()
    {
        $this->actingAs(factory('App\User')->create());
        $attributes=factory('App\Project')->raw(['tittle' =>'']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('tittle');
    }
    /** @test */
    public function validateDescription()
    {
        $this->actingAs(factory('App\User')->create());
        $attributes=factory('App\Project')->raw(['description' =>'']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
    
    /** @test */
    public function canViewTheirProject()
    {
        $this->actingAs(factory('App\User')->create());
        $this->withoutExceptionHandling();
        $project=factory('App\Project')->create(['user_id'=> auth()->id()]);
        $this->get($project->path())->assertSee($project->tittle)->assertSee($project->description);
    }
    /** @test */
    public function cannotViewOtherPeopleProject()
    {
        $this->actingAs(factory('App\User')->create());
        $project=factory('App\Project')->create();
        $this->get($project->path())->assertStatus(403);
    }
    /** @test */
    public function belongsToAUser()
    {
        $project=factory('App\Project')->create();
        $this->assertInstanceOf('App\User', $project->user);
    }
}
