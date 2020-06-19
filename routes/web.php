<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/Users','Users@userList');
Route::post('/User','Users@insertUser');
Route::delete('/User/{userId}','Users@deleteUser');
Route::put('/User/{userId}/{newStatus}','Users@userStatus');

Route::get('/Books','Books@getBooks');
Route::post('/Book','Books@insertBook');
Route::delete('/Book/{bookId}','Books@deleteBook');
Route::put('/Book/{bookId}/{adminStatus}','Books@bookStatus');

Route::post('/Upload','Upload@uploadFile');
Route::get('/Download/{fileNames}','Books@downloadBook');
Route::get('/View/{fileNames}','Books@viewBook');





