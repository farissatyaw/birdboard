<?php

namespace Tests\Unit;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function hasProject()
    {
        $user=factory('App\User')->create();
        $this->assertInstanceOf(Collection::class, $user->projects);
    }
    /** @test */
    public function hasAllProjects()
    {
        $john=$this->signIn();
        ProjectFactory::ownedBy($john)->create();
        
        $this->assertCount(1, $john->allProjects());

        $sally=factory(User::class)->create();
        $nick=factory(User::class)->create();
        ProjectFactory::ownedBy($sally)->create()->invite($nick);

        $this->assertCount(1, $john->allProjects());
    }
}
