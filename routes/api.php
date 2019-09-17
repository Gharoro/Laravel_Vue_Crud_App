<?php

use App\Http\Controllers\BookController;
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

/*
|--------------------------------------------------------------------------
| @GET  mybooklist/books
| @desc Retrieve all books from database
|--------------------------------------------------------------------------
*/

Route::get('books', 'BookController@index');


/*
|--------------------------------------------------------------------------
| @GET mybooklist/book/{id}
| @desc Retrieve a single book with an id
|--------------------------------------------------------------------------
*/

Route::get('book/{id}', 'BookController@show');

/*
|--------------------------------------------------------------------------
| @POST mybooklist/book
| @desc Creates a book in the database
|--------------------------------------------------------------------------
*/

Route::post('book', 'BookController@store');

/*
|--------------------------------------------------------------------------
| @PUT mybooklist/books
| @desc Updates a book with a book_id
|--------------------------------------------------------------------------
*/

Route::put('book', 'BookController@store');

/*
|--------------------------------------------------------------------------
| @DELETE mybooklist/book
| @desc Deletes a book with an id from the database
|--------------------------------------------------------------------------
*/

Route::delete('book/{id}', 'BookController@destroy');
