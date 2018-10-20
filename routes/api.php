<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::get('dashboard', function () {
        return response()->json(['data' => 'Test Data']);
    });

    Route::get('users', 'Api\V1\UserController@index');
    Route::get('users/{id}', 'Api\V1\UserController@edit');
    Route::post('users', 'Api\V1\UserController@store');
    Route::delete('/users/{id}', 'Api\V1\UserController@delete'); 
    Route::post('/users/{id}', 'Api\V1\UserController@update');

    Route::get('vendors', 'Api\V1\VendorController@index');
    Route::get('vendors/{id}', 'Api\V1\VendorController@edit');
    Route::post('vendors', 'Api\V1\VendorController@store');
    Route::delete('/vendors/{id}', 'Api\V1\VendorController@delete'); 
    Route::post('/vendors/{id}', 'Api\V1\VendorController@update');

    Route::get('brands', 'Api\V1\BrandController@index');
    Route::post('brands', 'Api\V1\BrandController@store');
    Route::delete('/brands/{id}', 'Api\V1\BrandController@delete'); 
    Route::post('/brands/{id}', 'Api\V1\BrandController@update');

    Route::get('categories', 'Api\V1\CategoryController@index');
    Route::post('categories', 'Api\V1\CategoryController@store');
    Route::delete('/categories/{id}', 'Api\V1\CategoryController@delete'); 
    Route::post('/categories/{id}', 'Api\V1\CategoryController@update');

    Route::get('discharges', 'Api\V1\DischargeController@index');
    Route::post('discharges', 'Api\V1\DischargeController@store');
    Route::delete('/discharges/{id}', 'Api\V1\DischargeController@delete'); 
    Route::post('/discharges/{id}', 'Api\V1\DischargeController@update');

    Route::get('items', 'Api\V1\ItemController@index');
    Route::post('items', 'Api\V1\ItemController@store');
    Route::delete('/items/{id}', 'Api\V1\ItemController@delete'); 
    Route::post('/items/{id}', 'Api\V1\ItemController@update');

    Route::get('labgroups', 'Api\V1\LabGroupController@index');
    Route::post('labgroups', 'Api\V1\LabGroupController@store');
    Route::delete('/labgroups/{id}', 'Api\V1\LabGroupController@delete'); 
    Route::post('/labgroups/{id}', 'Api\V1\LabGroupController@update'); 

    Route::get('locations', 'Api\V1\LocationController@index');
    Route::post('locations', 'Api\V1\LocationController@store');
    Route::delete('/locations/{id}', 'Api\V1\LocationController@delete'); 
    Route::post('/locations/{id}', 'Api\V1\LocationController@update');
    
    Route::get('states', 'Api\V1\StateController@index');
    Route::post('states', 'Api\V1\StateController@store');
    Route::delete('/states/{id}', 'Api\V1\StateController@delete'); 
    Route::post('/states/{id}', 'Api\V1\StateController@update');

    Route::get('units', 'Api\V1\UnitController@index');
    Route::post('units', 'Api\V1\UnitController@store');
    Route::delete('/units/{id}', 'Api\V1\UnitController@delete'); 
    Route::post('/units/{id}', 'Api\V1\UnitController@update');

    Route::get('roles', 'Api\V1\RoleController@index');
    Route::post('roles', 'Api\V1\RoleController@store');
    Route::delete('/roles/{id}', 'Api\V1\RoleController@delete'); 
    Route::post('/roles/{id}', 'Api\V1\RoleController@update');

    Route::get('doctors', 'Api\V1\DoctorController@index');
    Route::get('doctors/{id}', 'Api\V1\DoctorController@edit');
    Route::post('doctors', 'Api\V1\DoctorController@store');
    Route::delete('/doctors/{id}', 'Api\V1\DoctorController@delete'); 
    Route::post('/doctors/{id}', 'Api\V1\DoctorController@update');

    Route::get('radiologics', 'Api\V1\RadiologicController@index');
    Route::get('radiologics/{id}', 'Api\V1\RadiologicController@edit');
    Route::post('radiologics', 'Api\V1\RadiologicController@store');
    Route::delete('/radiologics/{id}', 'Api\V1\RadiologicController@delete'); 
    Route::post('/radiologics/{id}', 'Api\V1\RadiologicController@update');

    Route::get('patients', 'Api\V1\PatientController@index');
    Route::get('patients/{id}', 'Api\V1\PatientController@edit');
    Route::post('patients', 'Api\V1\PatientController@store');
    Route::delete('/patients/{id}', 'Api\V1\PatientController@delete'); 
    Route::post('/patients/{id}', 'Api\V1\PatientController@update');

   // Route::resource('locations', 'LocationController', ['except' => ['create', 'edit']]);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    //Route::resource('locations', 'LocationController', ['except' => ['create', 'edit']]);

    // Route::get('locations', function () {
    //     return response()->json(['data' => 'Test Data']);
    // });
    
});