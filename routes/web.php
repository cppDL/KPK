<?php
// require base_path('routes/api.php'); 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PagesController::class, 'index']);
Route::get('/about', [PagesController::class, 'about']);
Route::get('/services', [PagesController::class, 'services']);

// Route::get('/hello', function () {
//     return "<h1>hello world</h1>";
// });

// Route::get('/about', function () {
//     return view("pages.about");
// });

// Route::get('/bla', function () {
//     return view("js.bla");
// });
