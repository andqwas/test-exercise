<?php

namespace App\Jobs;

use App\Models\Employee;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AssignTasksJob implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $unassignedTasks = Task::doesntHave('employees')->get();
        $employees = Employee::all()->shuffle();

        if ($unassignedTasks->isNotEmpty()) {
            foreach ($unassignedTasks as $i => $task) {
                $employee = $employees[$i % $employees->count()];
                $task->employees()->attach($employee->id);
            }
        }
    }
}
