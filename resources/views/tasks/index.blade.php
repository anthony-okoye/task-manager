<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body class="p-6 bg-gray-100">
    <h1 class="text-2xl font-bold mb-4">Task Manager</h1>

    <form action="/projects" method="POST" class="mb-4 p-4 bg-white shadow rounded">
        @csrf
        <input type="text" name="name" placeholder="Project Name" required class="border p-2 rounded">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Project</button>
    </form>

    <label for="projectSelect" class="font-bold">Select Project:</label>
    <select id="projectSelect" class="border p-2 rounded">
        <option value="">All Projects</option>
        @foreach($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
        @endforeach
    </select>

    @foreach($projects as $project)
        <div class="project-section" data-project-id="{{ $project->id }}">
            <h2 class="text-xl font-bold mt-4">{{ $project->name }}</h2>
            <ul class="task-list bg-white p-4 shadow rounded" data-project-id="{{ $project->id }}">
                @foreach($project->tasks->sortBy('priority') as $task)
                    <li class="p-2" data-task-id="{{ $task->id }}">
                        {{ $task->name }}
                        <form action="/tasks/{{ $task->id }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <input type="text" name="name" value="{{ $task->name }}" class="border p-1 rounded">
                            <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded">Edit</button>
                        </form>
                        <form action="/tasks/{{ $task->id }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>

            <form action="/tasks" method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <input type="text" name="name" placeholder="Task Name" required class="border p-2 rounded">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Task</button>
            </form>
        </div>
    @endforeach

    <script>
        console.log(typeof $.fn.sortable);

        $(".task-list").sortable({
            update: function(event, ui) {
                let taskOrder = $(this).sortable("toArray", { attribute: "data-task-id" });
                $.post("/tasks/reorder", { tasks: taskOrder, _token: "{{ csrf_token() }}" });
            }
        }).disableSelection();
    </script>
    <script>
        $("#projectSelect").change(function() {
            let selectedProject = $(this).val();
            $(".project-section").each(function() {
                if (selectedProject === "" || $(this).data("project-id") == selectedProject) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    </script>
</body>
</html>
