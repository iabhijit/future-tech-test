<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [DataController::class,'show'])->name('show');  //// show the page
Route::post('/', [DataController::class,'crudappPost'])->name(name:'post.crudapp'); ///// Insert the data
Route::get('/{id}/edit', [DataController::class, 'edit'])->name('crudapp.edit'); //// Edit item to show in popup
Route::put('/{id}', [DataController::class, 'update'])->name('crudapp.update'); /// Update the item
Route::delete('/{id}', [DataController::class, 'destroy'])->name('crudapp.destroy'); /// delete the item
Route::get('/{id}', [DataController::class, 'view'])->name('crudapp.show'); /// View data in ajax
