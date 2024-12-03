<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Devs\Initvel\Helpers\Main;

/**
 * DataController
 *
 * This controller is responsible for handling requests related to various pages
 * such as 'Home', 'About', and 'Contact'. It shares available languages with
 * the views and renders the respective views based on the request.
 */
class DataController extends Controller
{
    /**
     * DataController constructor.
     *
     * The constructor retrieves the available languages using the `Main::getLanguages()`
     * method from the `Devs\Initvel\Helpers\Main` class and shares them with all views.
     */
    public function __construct()
    {
        // Get available languages from Main helper
        $langs = Main::getLanguages();

        // Share languages with all views
        View::share([
            'langs' => $langs,
        ]);
    }

    /**
     * Show the homepage.
     *
     * This method returns the 'home' view when the home page is requested.
     * The view will have the list of available languages available.
     *
     * @return \Illuminate\View\View The home view
     */
    public function home()
    {
        return view('home');
    }

    /**
     * Show the About Us page.
     *
     * This method returns the 'about' view when the about page is requested.
     * The view will have the list of available languages available.
     *
     * @return \Illuminate\View\View The about view
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Show the Contact Us page.
     *
     * This method returns the 'contact' view when the contact page is requested.
     * The view will have the list of available languages available.
     *
     * @return \Illuminate\View\View The contact view
     */
    public function contact()
    {
        return view('contact');
    }
}
