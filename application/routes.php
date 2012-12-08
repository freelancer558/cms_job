<?php

// Documents
// http://bundles.laravel.com/bundle/routely
// Start the bundle if its not auto-started
Bundle::start('routely');
Route::get('/about', 'home@about');
Route::get('/users', 'users@index');
Route::get('/users/login', 'users@login');
Route::get('/users/(:num)', 'users@show');
Route::get('/users/(:num)/edit', 'users@edit');
Route::post('/users/(:num)/edit', 'users@edit');
Route::get('/users/(:num)/delete', 'users@destroy');
Route::get('/users/repairing', 'users@repairing');

Route::get('/products', 'products@index');
Route::get('/products/(:num)', 'products@show');
Route::get('/products/(:num)/edit', 'products@edit');
Route::post('/products/(:num)/edit', 'products@edit');
Route::get('/products/(:num)/delete', 'products@destroy');
Route::get('/products/(:num)/detail', 'products@detail');

Route::get('/repairs', 'repairs@index');
Route::get('/repairs/(:num)/delete', 'repairs@destroy');
Route::post('/repairs(:all)', 'repairs@create');

Route::get('/chemicals', 'chemicals@index');
Route::get('/chemicals/new', 'chemicals@new');
Route::post('/chemicals/addtype', 'chemicals@addtype');
Route::get('/chemicals/(:num)', 'chemicals@show');
Route::get('/chemicals/(:num)/edit', 'chemicals@edit');
Route::post('/chemicals/(:num)/edit', 'chemicals@edit');
Route::get('/chemicals/(:num)/delete', 'chemicals@destroy');
Route::get('/chemicals/(:num)/detail', 'chemicals@detail');

Route::get('/requirements', 'requirements@index');
Route::get('/requirements/(:num)/delete', 'requirements@destroy');
Route::post('/requirements/requisition', 'requirements@requisition');
Route::post('/requirements/update_status', 'requirements@update_status');

Route::controller(Controller::detect());
/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Sentry::check()) return Redirect::to('dashboard');
});

Route::filter('nonauth', function()
{
	if (Sentry::check() == false) return Redirect::to('home');
});