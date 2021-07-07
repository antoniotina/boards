<?php

use App\Http\Controllers\BoardsController;
use App\Http\Controllers\ColumnController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

// Connected and verified only
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // See the board to the current "Team/Project"
    Route::get('/boards', [BoardsController::class, 'index'])->name('boards.index');

    // See the board to the current "Team/Project"
    Route::get('/board/{board}', [BoardsController::class, 'show'])->name('boards.show');

    // Sends the form data for the board to be validated and created
    Route::post('/board/store', [BoardsController::class, 'store'])->name('boards.store');

    // Sends the form data for the column to be validated and created
    Route::post('/board/{board}/column/store', [ColumnController::class, 'store'])->name('column.store');

    // Sends the form data for the column to be validated and updated
    Route::put('/column/{column}/update', [ColumnController::class, 'update'])->name('column.update');

    // Deletes the column
    Route::delete('/column/{column}/destroy', [ColumnController::class, 'destroy'])->name('column.destroy');

    // Returns the create a board view
    Route::delete('/board/{board}/destroy', [BoardsController::class, 'destroy'])->name('boards.destroy');

});