<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Devs\Initvel\Helpers\Main;

/**
 * SetLang Middleware
 *
 * This middleware is responsible for setting the application's language based on the
 * requested language. It retrieves the available languages and checks if the requested
 * language exists in the list of available languages. If valid, it sets the application's
 * locale and stores it in the session.
 */
class SetLang
{
    /**
     * Handle an incoming request.
     *
     * This method determines the language for the request. It checks if the language
     * is provided in the URL (via route parameters or the first URL segment), and sets
     * the application locale accordingly.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Get the list of available languages from the Main helper
        $langs = Main::getLanguages();

        // Determine the requested language (either from the route or URL segment)
        $lang = $request->route('lang') ?: $request->segment(1);

        // If the requested language is in the available languages, set it; otherwise, default to 'en'
        if (in_array($lang, $langs)) {
            $locale = $lang;
        } else {
            $locale = 'en';
        }
        
        // Set the application's locale to the selected language
        App::setLocale($locale);

        // Store the selected language in the session for persistence
        Session::put('locale', $locale);

        // Proceed to the next middleware
        return $next($request);
    }
}
