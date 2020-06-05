<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;

class ProjectsTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    /** @test */
    public function guestCannotManageProject()
    {
        $project=factory('App\Project')->create();

        $this->assertGuest();
        $this->get('/projects/create')->assertRedirect('/login');
        $this->post('/projects', $project->toArray())->assertRedirect('/login');
        $this->get($project->path())->assertRedirect('/login');
    }
    /** @test */
    public function unAuthCannotDelete()
    {
        $project=ProjectFactory::create();
        $this->signIn();
        $this->delete($project->path())->assertStatus(403);
    }
    /** @test */
    public function CreateProject()
    {
        $this->signIn();
        $this->get('/projects/create')->assertStatus(200);
        $attributes=[
            'tittle'=>$this->faker->sentence,
            'description'=>$this->faker->paragraph,
            'notes'=>'General notes here.'
        ];
        $this->post('/projects', $attributes);
        $project=Project::where($attributes)->first();
        $this->assertDatabaseHas('projects', $attributes);
        $this->get($project->path())
            ->assertSee($attributes['tittle'])
            ->assertSee(\Illuminate\Support\Str::limit($project->description, 100))
            ->assertSee($attributes['notes']);
    }
    /** @test */
    public function DeleteProject()
    {
        $this->withoutExceptionHandling();
        $project=ProjectFactory::create();
        $this->actingAs($project->user)->delete($project->path());
        $this->assertDatabaseMissing('projects', $project->only('id'));
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
        $project=ProjectFactory::create();
        $this->actingAs($project->user)
            ->get($project->path())
            ->assertSee($project->tittle)
            ->assertSee(\Illuminate\Support\Str::limit($project->description, 100));
    }
    /** @test */
    public function canViewAllOfTheirProject()
    {
        $user=$this->signIn();
        $project=ProjectFactory::create();
        $project->invite($user);

        $this->get('/projects')->assertSee($project->tittle);
    }
    /** @test */
    public function canUpdateTheirProject()
    {
        $project=ProjectFactory::create();
        $this->actingAs($project->user)->patch(
            $project->path(),
            $attributes= [
            'tittle'=>'Changed',
            'description' => 'Changed',
            'notes'=>'Changed'
            ]
        );
        $this->assertDatabaseHas('projects', $attributes);
    }
    /** @test */
    public function canUpdateTheirGeneralNotes()
    {
        $project=ProjectFactory::create();
        $this->actingAs($project->user)->patch(
            $project->path(),
            $attributes= [
            'notes'=>'Changed'
            ]
        );
        $this->assertDatabaseHas('projects', $attributes);
    }
    /** @test */
    public function cannotViewOtherPeopleProject()
    {
        $this->actingAs(factory('App\User')->create());
        $project=factory('App\Project')->create();
        $this->get($project->path())->assertStatus(403);
    }
    /** @test */
    public function cannotUpdateOtherPeopleProject()
    {
        $this->signIn();
        $project=factory('App\Project')->create();
        $this->patch($project->path(), [
            'notes'=>'Changed'
        ])->assertStatus(403);
    }
    /** @test */
    public function belongsToAUser()
    {
        $project=factory('App\Project')->create();
        $this->assertInstanceOf('App\User', $project->user);
    }
}
