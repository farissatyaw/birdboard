<?php

namespace Tests\Feature;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function ownerCanInviteUser()
    {
        $this->withoutExceptionHandling();
        $project=ProjectFactory::create();
        $invitedUser=factory('App\User')->create();

        $this->be($project->user)->post($project->path() . '/invite', [
            'email' => $invitedUser ->email
        ]);

        $this->assertTrue($project->members->contains($invitedUser));
    }
    /** @test */
    public function onlyOwnerCanInvite()
    {
        $project=ProjectFactory::create();
        $user=factory('App\User')->create();
        $this->be($user)->post($project->path() . '/invite')->assertStatus(403);

        $project->invite($user);
        $this->post($project->path() . '/invite')->assertStatus(403);
    }
    /** @test */
    public function authInvitedUserMayUpdate()
    {
        $project=ProjectFactory::create();
        $project->invite($newUser = factory(User::class)->create());

        $this->signIn($newUser);
        $this->post(action('ProjectTaskController@store', $project), $task=['body' => 'foo task']);

        $this->assertDatabaseHas('tasks', $task);
    }
    /** @test */
    public function invitedUserMustBeRegistered()
    {
        $project=ProjectFactory::create();
        $this->be($project->user)
            ->post($project->path() . '/invite', [
            'email' => 'notAUser@example.com'
        ])
            ->assertSessionHasErrors([
                'email'=>"The user does not have a birdboard account."
                ]);
    }
}
