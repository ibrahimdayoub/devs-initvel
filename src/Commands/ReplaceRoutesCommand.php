<?php

namespace Devs\Initvel\Commands;

use Illuminate\Console\Command;

/**
 * ReplaceRoutesCommand Class
 * 
 * This command replaces the main `web.php` routes file in the Laravel project with
 * the package's `web.php` routes file. It ensures that the project's routes are 
 * synchronized with the routes provided by the package.
 */
class ReplaceRoutesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'routes:replace';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replace main web.php routes with package web.php routes';

    /**
     * Handle the execution of the command.
     *
     * This method reads the routes file from the package, then replaces
     * the main `routes/web.php` file in the Laravel project with the package's version.
     * It provides feedback to the user about the operation status.
     *
     * @return void
     */
    public function handle()
    {
        // Define the path to the package's web.php routes file
        $packageRoutes = __DIR__ . '/../../routes/web.php';

        // Define the path to the main web.php routes file in the Laravel project
        $mainRoutes = base_path('routes/web.php');

        // Check if the package's routes file exists
        if (file_exists($packageRoutes)) {
            // Read the content of the package's routes file
            $packageRoutesContent = file_get_contents($packageRoutes);

            // Overwrite the main web.php file with the package's routes content
            file_put_contents($mainRoutes, $packageRoutesContent);

            // Display success message in the console
            $this->info('Main routes have been replaced with package routes.');
        } else {
            // Display error message if the package's routes file is not found
            $this->error('Package routes file not found.');
        }
    }
}