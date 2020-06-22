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


/*
 * Admin RESTful APIs
*/
Route::get('/Users','Users@getUserList')->middleware('authInterceptorAdmin');
Route::put('/User/{userId}/{newStatus}','Users@updateUserStatus')->middleware('authInterceptorAdmin');
Route::delete('/User/{userId}','Users@deleteUser')->middleware('authInterceptorAdmin');

Route::get('/Books/AllPublished','Books@getAllPublishedBooks')->middleware('authInterceptorAdmin');
Route::put('/BookAdminApproval/{bookId}/{bookStatus}','Books@updateBookAdminStatus')->middleware('authInterceptorAdmin');

/*
 * Publisher RESTful APIs
*/
Route::get('/Books/MyPublished','Books@getMyPublishedBooks')->middleware('authInterceptorPublisher');
Route::post('/Book','Books@insertBook')->middleware('authInterceptorPublisher');
Route::delete('/Book/{bookId}','Books@deleteBook')->middleware('authInterceptorPublisher');
Route::put('/BookPublisherApproval/{bookId}/{bookStatus}','Books@updateBookPublisherStatus')->middleware('authInterceptorPublisher');

/*
 * User RESTful APIs
*/
Route::get('/Books','Books@getAllActiveBooks')->middleware('authInterceptorReader'); /* Activated by admin as well as by publisher */
Route::get('/Download/{fileNames}','Books@downloadBook')->middleware('authInterceptorReader');
Route::get('/View/{fileNames}','Books@viewBook')->middleware('authInterceptorReader');

/*
 * Guest RESTful APIs
*/
Route::post('/User','Users@insertUser');
Route::post('/Authentication/Authenticate','Users@userAuthenticate');



