<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Project;
use App\Models\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_project()
    {
        $response = $this->post('/projects', ['name' => 'New Project']);
        $response->assertStatus(302);
        $this->assertDatabaseHas('projects', ['name' => 'New Project']);
    }

    public function test_user_can_create_task()
    {
        $project = Project::factory()->create();
        $response = $this->post('/tasks', ['name' => 'New Task', 'project_id' => $project->id]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks', ['name' => 'New Task']);
    }

    public function test_tasks_are_filtered_by_project()
    {
        $project1 = Project::factory()->create();
        $project2 = Project::factory()->create();
        
        Task::factory()->create(['name' => 'Task 1', 'project_id' => $project1->id]);
        Task::factory()->create(['name' => 'Task 2', 'project_id' => $project2->id]);

        $response = $this->get('/tasks?project_id=' . $project1->id);
        $response->assertSee('Task 1');
        $response->assertDontSee('Task 2');
    }
}
