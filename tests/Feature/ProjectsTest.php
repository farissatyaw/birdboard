<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    /** @test */
    public function validateAuthUser()
    {
        $attributes=factory('App\Project')->raw();
        $this->post('/projects', $attributes)->assertRedirect('/login');
    }
    /** @test */
    public function CreateProject()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory('App\User')->create());
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
    public function canViewAProject()
    {
        $this->withoutExceptionHandling();
        $project=factory('App\Project')->create();
        $this->get($project->path())->assertSee($project->tittle)->assertSee($project->description);
    }
}
