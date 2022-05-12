<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\suggestionActivity;

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
use App\Http\Controllers\AjaxCOMMENTCRUDController;

Route::get('/', function () { //Route to welcome user menu view
    return view('welcome-menu');
})->name('welcome-menu');

Route::get('/ajax-restricted-comment-crud', function () { //Route to restricted comment bank view
    return view('ajax-restricted-comment-crud');
})->name('ajax-restricted-comment-crud');

//Minimal CRUD route permissions to allow all users to view and make comment suggestions
Route::get('fetch-comments', [AjaxCOMMENTCRUDController::class, 'fetchComments']);
Route::get('fetch-comments-by-type', [AjaxCOMMENTCRUDController::class, 'fetchCommentsByType']);
Route::post('save-comment', [AjaxCOMMENTCRUDController::class, 'store']);

Route::get('/suggestion-activity',function(){ //Route to send comment suggestion email alert to admin 
    Mail::to('me@somewhere.com')->send(new suggestionActivity());
    return redirect('ajax-restricted-comment-crud');
})->name('suggestion-activity');

// ------------------------Authentication-only Access Routes for Admin---------------------
Route::group(['middleware' => 'auth','verified'], function(){ //Enforce authentication group
    Route::get('/dashboard', function () { //Route to admin dashboard view
        return view('dashboard');
    })->name('dashboard'); 
   
    Route::get('/ajax-admin-comment-crud', function () { //Route to admin comment bank view
        return view('ajax-admin-comment-crud');
    })->name('ajax-admin-comment-crud'); 
    
    Route::get('/ajax-review-comments', function () { //Route to review unapproved comments view
        return view('ajax-review-comments');
    })->name('ajax-review-comments'); 

    //Full route permissions to allow admin full CRUD functionality
    Route::get('edit-comment/{id}', [AjaxCOMMENTCRUDController::class, 'edit']);
    Route::put('update-comment/{id}', [AjaxCOMMENTCRUDController::class, 'update']);
    Route::delete('delete-comment/{id}', [AjaxCOMMENTCRUDController::class, 'destroy']);

    Route::view('profile', 'profile')->name('profile');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});


require __DIR__.'/auth.php';