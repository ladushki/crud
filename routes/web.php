<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin', function () {
    return view('admin/dashboard');
})->middleware('auth');

Auth::routes(['register' => false]);

Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');

Route::get('images/{filename}', function ($filename) {
    $path = storage_path('app/public/'.$filename);

    if (! File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::group(['before' => 'auth', 'prefix' => 'admin', 'middleware' => 'auth',], function () {
    Route::get('/companies', ['as' => 'company.list', 'uses' => '\App\Http\Controllers\CompanyController@index']);
    Route::get('/employees', ['as' => 'employee.list', 'uses' => '\App\Http\Controllers\EmployeeController@index']);
});

Route::group(['before' => 'auth', 'prefix' => 'admin/company', 'middleware' => 'auth',], function () {
    Route::get('/create', [
        'as' => 'company.create',
        'uses' => '\App\Http\Controllers\CompanyController@create',
    ]);
    Route::get('/show/{id}', [
        'as' => 'company.show',
        'uses' => '\App\Http\Controllers\CompanyController@show',
    ]);
    Route::match(['post', 'put', 'get'],'/store', [
        'as' => 'company.store',
        'uses' => '\App\Http\Controllers\CompanyController@store',
    ]);
    Route::post('/delete', [
        'as' => 'company.delete',
        'uses' => '\App\Http\Controllers\CompanyController@delete',
    ]);
    Route::get('/edit/{id}', [
        'as' => 'company.edit',
        'uses' => '\App\Http\Controllers\CompanyController@edit',
    ]);
    Route::match(['delete', 'post'], '/destroy/{id}', [
        'as' => 'company.destroy',
        'uses' => '\App\Http\Controllers\CompanyController@destroy',
    ]);
    Route::match(['patch', 'put', 'post'], '/update/{id}', [
        'as' => 'company.update',
        'uses' => '\App\Http\Controllers\CompanyController@update',
    ]);
});

Route::group(['before' => 'auth', 'prefix' => 'admin/employee', 'middleware' => 'auth',], function () {
    Route::get('/create', [
        'as' => 'employee.create',
        'uses' => '\App\Http\Controllers\EmployeeController@create',
    ]);
    Route::get('/show/{id}', [
        'as' => 'employee.show',
        'uses' => '\App\Http\Controllers\EmployeeController@show',
    ]);
    Route::match(['post', 'put'],'/store', [
        'as' => 'employee.store',
        'uses' => '\App\Http\Controllers\EmployeeController@store',
    ]);
    Route::post('/delete', [
        'as' => 'employee.delete',
        'uses' => '\App\Http\Controllers\EmployeeController@delete',
    ]);
    Route::get('/edit/{id}', [
        'as' => 'employee.edit',
        'uses' => '\App\Http\Controllers\EmployeeController@edit',
    ]);
    Route::match(['delete', 'post'], '/destroy/{id}', [
        'as' => 'employee.destroy',
        'uses' => '\App\Http\Controllers\EmployeeController@destroy',
    ]);
    Route::match(['patch', 'put', 'post'], '/update/{id}', [
        'as' => 'employee.update',
        'uses' => '\App\Http\Controllers\EmployeeController@update',
    ]);
});
