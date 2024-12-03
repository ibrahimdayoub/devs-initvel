<?php

namespace Devs\Initvel\Commands;

use Illuminate\Console\Command;

/**
 * MultiTaskCommand Class
 *
 * This command allows you to run multiple Artisan commands at once. 
 * It provides functionality to run all predefined commands or execute 
 * a specific command based on user input.
 */
class MultiTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initvel:setup-all {--specific= : Run only a specific command}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run multiple Artisan commands';

    /**
     * Handle the execution of the command.
     *
     * This method checks if a specific command was requested via the `--specific` option.
     * If so, it runs the specific task; otherwise, it runs all the predefined tasks.
     *
     * @return int
     */
    public function handle()
    {
        // Retrieve the value of the 'specific' option from the command line
        $specific = $this->option('specific');

        // If a specific command was provided, run that specific command
        if ($specific) {
            $this->callSpecificTask($specific);
            return 0; // Exit after specific task is completed
        }

        // If no specific command, run all tasks
        $this->info('Running all package commands...');

        // Run a series of vendor publish commands
        $this->call('vendor:publish', ['--tag' => 'initvel-http']);
        $this->call('vendor:publish', ['--tag' => 'initvel-views']);
        $this->call('vendor:publish', ['--tag' => 'initvel-assets']);
        $this->call('routes:replace');

        $this->info('All package commands executed successfully!');
        return 0;
    }

    /**
     * Run a specific task based on the user input.
     *
     * This method runs one of the predefined tasks if the 'specific' option is used.
     *
     * @param string $task
     * @return void
     */
    protected function callSpecificTask($task)
    {
        // Inform the user about which specific task is being executed
        $this->info("Running specific package command: {$task}...");

        // Switch based on the provided task name and run the corresponding command
        switch ($task) {
            case 'initvel-http':
                $this->call('vendor:publish', ['--tag' => 'initvel-http']);
                break;
            case 'initvel-views':
                $this->call('vendor:publish', ['--tag' => 'initvel-views']);
                break;
            case 'initvel-assets':
                $this->call('vendor:publish', ['--tag' => 'initvel-assets']);
                break;
            case 'routes-replace':
                $this->call('routes:replace');
                break;
            default:
                // If the task doesn't match any of the known ones, show an error
                $this->error("Unknown task: {$task}");
                break;
        }

        // Inform the user that the specific task was executed successfully
        $this->info("Package command {$task} executed successfully!");
    }
}