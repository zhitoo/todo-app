<?php

namespace App\Observers;

use App\Events\Task\StatusChanged;
use App\Models\Task;

class TaskObserver
{


    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        if ($task->isDirty('completed')) {
            event(new StatusChanged($task));
        }
    }
}
