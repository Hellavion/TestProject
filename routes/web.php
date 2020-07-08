<?php

use App\Models\Task;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

/**
 * Вывести панель с задачами
 */
Route::get('/', 'TaskController@index');

Route::resource('task', 'TaskController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
