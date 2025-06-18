<?php

namespace App\Observers;

use App\Models\Notification;
use App\Models\Task;

class TaskObserver
{
    public function updated(Task $task): void
    {
        if ($task->isDirty('status')) {
            $newStatus = $task->status;

            if ($newStatus === Task::STATUS_IN_PROGRESS
                || $newStatus === Task::STATUS_COMPLETED) {
                $this->sendNotifications($task, $newStatus);
            }
        }
    }

    protected function sendNotifications(Task $task, string $newStatus): void
    {
        $message = "Задача #$task->id была переведена в статус '$newStatus'";
        $employees = $task->employees();

        $employees->each(function ($employee) use ($task, $message) {
            Notification::create([
                'employee_id' => $employee->id,
                'message' => $message
            ]);
        });
    }
}
