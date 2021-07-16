<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\siteController; 


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

Route::get('/', [siteController::class, 'index']);

Route::redirect('/articles', '/');

Route::match(['get', 'post'], '/articles/new', [siteController::class,'newArticles']);

Route::match(['get', 'post'], '/author/list', [siteController::class,'listAuthor']);

Route::get('/articles/{id}', [SiteController::class,'getArticles']);


Route::get('/article/delete/{id}/{comment}', [siteController::class,'deleteArtikel']);

Route::match(['get', 'post'],'/comment/{id}', [siteController::class,'commentAdd']);

Route::match(['get', 'post'],'/article/edit/{id}', [siteController::class,'editArtikel']);