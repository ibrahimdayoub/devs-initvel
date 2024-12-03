<?php

namespace Devs\Initvel\Helpers;

use Illuminate\Support\Facades\File;

/**
 * Main Helper Class
 *
 * This class provides helper methods to manage languages in the application. 
 * It includes functions to get available languages and change the language of the current page.
 */
class Main
{
    /**
     * Get the list of available languages from the resources/lang directory.
     *
     * This method scans the `resources/lang` directory for subdirectories representing languages.
     * It returns an array of language codes (e.g., 'en', 'es', 'fr').
     * If no languages are found, it defaults to English ('en').
     *
     * @return array List of available languages
     */
    public static function getLanguages()
    {
        // Path to the resources/lang directory
        $langPath = resource_path('lang');

        // Check if the directory exists and contains subdirectories
        if (File::exists($langPath) && $directories = File::directories($langPath)) {
            // Return the list of language directories as an array
            return collect($directories)->map(function ($path) {
                return basename($path);  // Get the directory name (language code)
            })->toArray();
        }

        // Return English as the default language if no directories are found
        return ['en'];
    }

    /**
     * Change the language of the current page.
     *
     * This method updates the URL to change the language by modifying the first segment of the path.
     * It checks if the current language is part of the URL and replaces it with the new language.
     * If no language is found in the URL, it prepends the new language to the path.
     *
     * @param string $lang The new language code to switch to
     * @return \Illuminate\Http\RedirectResponse The redirect response to the new language URL
     */
    public static function changeLang($lang)
    {
        // Get the list of available languages
        $langs = self::getLanguages();

        // Get the current path from the request
        $currentPath = request()->get('current', '');

        // Split the current path by '/'
        $segments = explode('/', $currentPath);

        // Check if the first segment is a valid language code
        if (isset($segments[0]) && in_array($segments[0], $langs)) {
            // Replace the first segment with the new language
            $segments[0] = $lang;
        } else {
            // Prepend the new language code to the path
            array_unshift($segments, $lang);
        }

        // Rebuild the URL with the new language
        $newPath = implode('/', $segments);

        // Redirect to the new URL with the language
        return redirect('/' . $newPath);
    }
}
