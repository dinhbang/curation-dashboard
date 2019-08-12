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
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});
Route::get('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/');
});

Route::get('/home',['as'=>'home','uses'=>'HomeController@index']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/app',['as'=>'app','uses'=>'HomeController@app']);
    Route::get('/all/data',['as'=>'all_data','uses'=>'CategoryController@allData']);

    Route::group(['prefix'=>'country','as'=>'country.'],function () {
        Route::get('/',['as'=>'all','uses'=>'CountryController@getList']);
        Route::post('/',['as'=>'store','uses'=>'CountryController@store']);
        Route::post('/{country}',['as'=>'update','uses'=>'CountryController@update']);
        Route::post('/del/{rule}',['as'=>'delete','uses'=>'CountryController@delete']);
    });

    Route::group(['prefix'=>'rule','as'=>'rule.'],function () {
        Route::get('/',['as'=>'all','uses'=>'RuleController@getList']);
        Route::get('/category/{categoryId}',['as'=>'category','uses'=>'RuleController@getByCategory']);
        Route::post('/',['as'=>'store','uses'=>'RuleController@store']);
        Route::post('/{rule}',['as'=>'update','uses'=>'RuleController@update']);
        Route::post('/del/{rule}',['as'=>'delete','uses'=>'RuleController@delete']);

    });

    Route::group(['prefix'=>'types','as'=>'types.'],function () {
        Route::get('/',['as'=>'all','uses'=>'TypeController@getList']);
        Route::get('/country/{countryId}',['as'=>'country','uses'=>'TypeController@getByCountry']);
        Route::post('/',['as'=>'store','uses'=>'TypeController@store']);
        Route::post('/{type}',['as'=>'update','uses'=>'TypeController@update']);
        Route::post('/del/{rule}',['as'=>'delete','uses'=>'TypeController@delete']);
    });

    Route::group(['prefix'=>'category','as'=>'category.'],function () {
        Route::get('/rule/{categoryId}',['as'=>'rule','uses'=>'CategoryController@getRules']);
        Route::get('/',['as'=>'all','uses'=>'CategoryController@getAll']);

        Route::post('/',['as'=>'store','uses'=>'CategoryController@store']);
        Route::post('/add-rule',['as'=>'storeRule','uses'=>'CategoryController@storeRule']);
        Route::post('/add-all',['as'=>'storeAll','uses'=>'CategoryController@storeAll']);
        Route::post('/{category}',['as'=>'update','uses'=>'CategoryController@update']);
        Route::post('/del/{category}',['as'=>'delete','uses'=>'CategoryController@delete']);
        Route::post('/del-rule/{category}',['as'=>'deleteRule','uses'=>'CaegoryController@deleteRule']);
    });
    //die("abc");

});

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
