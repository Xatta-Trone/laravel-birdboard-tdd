<?php

namespace Tests\Feature;

use App\Models\Project;
use Database\Factories\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * test a project can be created
     *
     * @return void
     */

    public function test_a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
        $attributes  = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);
        $this->get('/projects')->assertSee($attributes);
    }

    /**
     * test
     *
     * @return void
     */

    public function test_project_requires_a_title()
    {
        $attributes = Project::factory()->raw(['title' => '']);


        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /**
     * test
     *
     * @return void
     */

    public function test_project_requires_a_description()
    {
        $attributes = Project::factory()->raw(['description' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }



    /**
     * test a user can view a project
     *
     * @return void
     */

    public function test_a_user_can_view_a_project()
    {
        $this->withoutExceptionHandling();
        $project =  Project::factory()->create();

        $this->get($project->path())->assertSee($project->title)->assertSee($project->description);
    }
}
