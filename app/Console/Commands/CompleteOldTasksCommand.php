<?php

namespace App\Console\Commands;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CompleteOldTasksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:complete-olds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto complete old tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //complete task if after two years not completed!
        Task::query()
            ->where('completed', false)
            ->where('created_at', '<', Carbon::now()->subDays(2))
            ->update([
                'completed' => true
            ]);
    }
}
