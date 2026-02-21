<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

/**
 * Application base controller.
 *
 * Laravel's default controller scaffold extends the framework's
 * `Illuminate\Routing\Controller` which provides the `middleware()` helper
 * among other conveniences. In this project the stub had been replaced with
 * an empty class, so calls to `$this->middleware()` resulted in "undefined
 * method" errors. Extending the framework base restores normal behaviour.
 */
abstract class Controller extends BaseController
{
    // You can place shared logic for your controllers here.
}
