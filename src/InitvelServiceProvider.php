<?php

namespace Devs\Initvel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Devs\Initvel\Helpers\Main;

/**
 * Initvel Service Provider
 *
 * This service provider is responsible for registering and booting the Initvel package services,
 * including registering Artisan commands, publishing package assets, views, and middleware configuration.
 */
class InitvelServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * The register method is used to bind services into the service container. 
     * It registers Artisan commands and binds the Main helper class as a singleton service.
     *
     * @return void
     */
    public function register()
    {
        try {
            // Register custom Artisan commands
            $this->commands([
                Commands\AppendLangsCommand::class,
                Commands\ReplaceRoutesCommand::class,
                Commands\MultiTaskCommand::class,
            ]);

            // Bind the Main helper class as a singleton
            $this->app->singleton(Main::class);

        } catch (\Exception $e) {
            // Handle any exception that occurs during the register process
            dd('Error in register method: ' . $e->getMessage());
        }
    }

    /**
     * Bootstrap the application services.
     *
     * The boot method is used to perform any actions that need to happen when the package is loaded,
     * such as publishing assets, views, and other files to the application's directories.
     *
     * @return void
     */
    public function boot()
    {
        try {
            // Publish package's HTTP controllers
            $this->publishes([
                __DIR__ . '/Http/' => app_path('Http/'),
            ], 'initvel-http');

            // Publish package assets and logo
            $this->publishes([
                __DIR__ . '/../public/assets/' => public_path('assets/'),
                __DIR__ . '/../public/logo.ico' => public_path('logo.ico'),
            ], 'initvel-assets');

            // Publish package views
            $this->publishes([
                __DIR__ . '/../resources/views/' => resource_path('views/'),
            ], 'initvel-views');

            // Register middleware configuration based on Laravel version
            $this->registerMiddlewareMode();

        } catch (\Exception $e) {
            // Handle any exception that occurs during the boot process
            dd('Error in boot method: ' . $e->getMessage());
        }
    }

    /**
     * Register middleware based on Laravel version.
     *
     * This method checks the version of Laravel being used and registers appropriate middleware.
     * It handles the logic of determining which middleware configuration to apply based on the Laravel version.
     *
     * @return void
     */
    protected function registerMiddlewareMode()
    {
        // Get the Laravel framework version from composer.json
        $composerLockPath = base_path('composer.json');
        $composerData = json_decode(file_get_contents($composerLockPath), true);

        $version = $composerData['require']['laravel/framework'];

        // Remove caret (^) symbol to get the actual version number
        $version = ltrim($version, '^');

        // Split version string into major, minor, and patch parts
        $parts = explode('.', $version);

        // Use the major version for determining the middleware registration logic
        $version = intval($parts[0]);

        // Register middleware based on Laravel major version
        if ($version == 11) {
            $this->registerMiddleware();
        } else {
            $this->registerMiddlewareAlt();
        }
    }

    /**
     * Register Middleware for Laravel Version 11
     *
     * This method modifies the `bootstrap/app.php` file to register middleware for Laravel version 11.
     * It checks if the `->withMiddleware` method exists and updates it accordingly by adding the 
     * `SetLang` middleware and the `ResponseCache` alias middleware.
     */
    protected function registerMiddleware()
    {
        // Path to the bootstrap/app.php file
        $appConfigPath = base_path('bootstrap/app.php');

        // Check if the bootstrap/app.php file exists
        if (!File::exists($appConfigPath)) {
            throw new \Exception("The bootstrap/app.php file does not exist.");
        }

        // Get the contents of the bootstrap/app.php file
        $appConfigContents = File::get($appConfigPath);

        // Middleware code to be injected
        $middlewareCode = <<<EOD
        ->withMiddleware(function (Middleware \$middleware) {
            // Apply middleware to all web routes
            \$middleware->web([
                \App\Http\Middleware\SetLang::class,
            ]);

            // Define alias middleware
            \$middleware->alias([
                'response.cache' => \App\Http\Middleware\ResponseCache::class,
            ]);
        })
        EOD;

        // Check if the ->withMiddleware method exists in the file
        if (strpos($appConfigContents, '->withMiddleware') === false) {
            // If not, add the middleware code after the ->withRouting method
            $appConfigContents = preg_replace(
                '/->withRouting\((.*?)\)/s',
                "->withRouting(\$1)\n" . $middlewareCode,
                $appConfigContents
            );
        } else {
            // If ->withMiddleware exists, replace it with the updated middleware code
            $appConfigContents = preg_replace(
                '/->withMiddleware\(function \(Middleware .*?\}\)/s',
                $middlewareCode,
                $appConfigContents
            );
        }

        // Save the modified content back to the bootstrap/app.php file
        File::put($appConfigPath, $appConfigContents);
    }

    /**
     * Register Middleware for Other Laravel Versions
     *
     * This method modifies the `app/Http/Kernel.php` file to register the necessary middleware 
     * for versions of Laravel that do not use the `->withMiddleware` method (i.e., older versions).
     * It adds the `SetLang` middleware to the 'web' middleware group and defines the alias 
     * for the `ResponseCache` middleware.
     */
    protected function registerMiddlewareAlt()
    {
        // Path to the app/Http/Kernel.php file
        $kernelPath = app_path('Http/Kernel.php');

        // Check if the Kernel.php file exists
        if (!File::exists($kernelPath)) {
            throw new \Exception("The Http/Kernel.php file does not exist.");
        }

        // Get the contents of the Kernel.php file
        $kernelContents = file_get_contents($kernelPath);

        // Pattern to match the 'web' middleware group
        $middlewareGroupPattern = "/'web'\s*=>\s*\[\s*(.*?)\s*\]/s";

        // Check if the 'web' middleware group exists and add the SetLang middleware if needed
        if (preg_match($middlewareGroupPattern, $kernelContents, $matches)) {
            $currentMiddlewareGroup = $matches[1];

            if (!str_contains($currentMiddlewareGroup, '\\App\\Http\\Middleware\\SetLang::class')) {
                $updatedMiddlewareGroup = str_replace(
                    $matches[1],
                    $matches[1] . "\n            \\App\\Http\\Middleware\\SetLang::class,",
                    $matches[0]
                );

                $kernelContents = str_replace($matches[0], $updatedMiddlewareGroup, $kernelContents);
            }
        }

        // Pattern to match the middlewareAliases array
        $middlewareAliasesPattern = "/middlewareAliases\s+=\s+\[\s*(.*?)\s*\];/s";

        // Check if the middlewareAliases array exists and add the ResponseCache alias if needed
        if (preg_match($middlewareAliasesPattern, $kernelContents, $matches)) {
            $currentMiddlewareAliases = $matches[1];

            if (!str_contains($currentMiddlewareAliases, "'response.cache' => \\App\\Http\\Middleware\\ResponseCache::class")) {
                $updatedMiddlewareAliases = str_replace(
                    $matches[1],
                    $matches[1] . "\n    'response.cache' => \\App\\Http\\Middleware\\ResponseCache::class,",
                    $matches[0]
                );

                $kernelContents = str_replace($matches[0], $updatedMiddlewareAliases, $kernelContents);
            }
        }

        // Pattern to match the routeMiddleware array
        $routeMiddlewarePattern = "/routeMiddleware\s+=\s+\[\s*(.*?)\s*\];/s";

        // Check if the routeMiddleware array exists and add the ResponseCache middleware if needed
        if (preg_match($routeMiddlewarePattern, $kernelContents, $matches)) {
            $currentRouteMiddleware = $matches[1];

            if (!str_contains($currentRouteMiddleware, "'response.cache' => \\App\\Http\\Middleware\\ResponseCache::class")) {
                $updatedRouteMiddleware = str_replace(
                    $matches[1],
                    $matches[1] . "\n    'response.cache' => \\App\\Http\\Middleware\\ResponseCache::class,",
                    $matches[0]
                );

                $kernelContents = str_replace($matches[0], $updatedRouteMiddleware, $kernelContents);
            }
        }

        // Save the modified content back to the Kernel.php file
        file_put_contents($kernelPath, $kernelContents);
    }
}
