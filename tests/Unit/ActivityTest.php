<?php

namespace Tests\Unit;

use App\Project;
use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function hasUser()
    {
        $this->withoutExceptionHandling();
        $project=ProjectFactory::create();
        $this->assertInstanceOf('App\User', $project->activity[0]->user);
    }
}
