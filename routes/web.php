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

Route::get('/users','Users@UserList');
Route::get('/users/reader','Users@ReaderList');
Route::get('/users/librarian','Users@LibList');
Route::post('/user','Users@InsertUser');
Route::delete('/user/{userId}','Users@DeleteUser');
//Route::delete('/user/{userId}', array('middleware' => 'CORS', 'uses' => 'Users@DeleteUser'));
Route::get('/books','Books@GetBooks');
Route::post('/book','Books@InsertBook');
Route::delete('/book/{bookId}','Books@DeleteBook')->name('rbKO37moSGLtH7rv4CSR2MXhrXffhNp6uDk9EE0M.pdf');
Route::post('/upload','Upload@UploadFile');
Route::get('/download/{fileNames}','Books@DownloadBook');
