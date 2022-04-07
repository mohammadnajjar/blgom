<?php

use App\Http\Controllers\Frontend\Auth\ForgotPasswordController;
use App\Http\Controllers\Frontend\Auth\LoginController;
use App\Http\Controllers\Frontend\Auth\RegisterController;
use App\Http\Controllers\Frontend\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\Auth\VerificationController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\UsersController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;


Route::get('/', [IndexController::class, 'index'])->name('frontend.index');
// Authentication Routes...

Route::get('/login', [loginController::class, 'showLoginForm'])->name('show_login-form');
Route::post('/login', [loginController::class, 'login'])->name('login');
Route::post('/logout', [loginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('show_registration-form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::group(['middleware' => 'verified'], function () {
    Route::get('/dashboard', [UsersController::class, 'index'])->name('dashboard');
    Route::any('user/notifications/get', [NotificationController::class, 'getNotification']);
    Route::any('user/notifications/read', [NotificationController::class, 'markAsRead']);
    Route::any('user/notifications/read/{id}', [NotificationController::class, 'markAsReadAndRedirect']);


    Route::get('/create_post', [UsersController::class, 'create_post'])->name('users.create_post');
    Route::post('/store_post', [UsersController::class, 'store_post'])->name('users.store_post');
    Route::get('/edit-post/{post_id}', [UsersController::class, 'edit_post'])->name('users.edit.post');
    Route::put('/update_post/{post_id}', [UsersController::class, 'update_post'])->name('users.update.post');
    Route::post('/delete_post_media/{media_id}', [UsersController::class, 'destroy_post_media'])->name('users.post.media.destroy');
    Route::delete('/delete_post/{post_id}', [UsersController::class, 'destroy_post'])->name('users.post.destroy');

    Route::get('/comments', [UsersController::class, 'show_comments'])->name('users.show.comments');
    Route::get('/edit-comment/{comment_id}', [UsersController::class, 'edit_comment'])->name('users.edit.comment');
    Route::put('/update_comment/{comment_id}', [UsersController::class, 'update_comment'])->name('users.update.comment');
    Route::delete('/delete_comment/{comment_id}', [UsersController::class, 'destroy_comment'])->name('users.comment.destroy');
//    Route::post('/delete_comment/{comment_id}', [UsersController::class, 'destroy_comment'])->name('users.comment.destroy');

    Route::get('/edit-info', [UsersController::class, 'edit_info'])->name('users.edit.info');
    Route::post('/update-info/', [UsersController::class, 'update_info'])->name('users.update.info');
    Route::post('/update-password/', [UsersController::class, 'update_password'])->name('users.update.password');

});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [\App\Http\Controllers\Backend\IndexController::class, 'index'])->name('backend.index');
    Route::get('/login', [\App\Http\Controllers\Backend\Auth\LoginController::class, 'showLoginForm'])->name('admin.show_login-form');
    Route::post('/login', [\App\Http\Controllers\Backend\Auth\loginController::class, 'login'])->name('admin.login');
    Route::post('/logout', [\App\Http\Controllers\Backend\Auth\loginController::class, 'logout'])->name('admin.logout');
    Route::get('password/reset', [\App\Http\Controllers\Backend\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
    Route::post('password/email', [\App\Http\Controllers\Backend\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
    Route::get('password/reset/{token}', [\App\Http\Controllers\Backend\Auth\ResetPasswordController::class, 'showLinkRequestForm'])->name('admin.password.reset');
    Route::post('password/reset', [\App\Http\Controllers\Backend\Auth\ResetPasswordController::class, 'reset'])->name('admin.password.update');
    Route::get('email/verify', [\App\Http\Controllers\Backend\Auth\VerificationController::class, 'show'])->name('admin.verification.notice');
    Route::get('/email/verify/{id}/{hash}', [\App\Http\Controllers\Backend\Auth\VerificationController::class, 'verify'])->name('admin.verification.verify');
    Route::post('email/resend', [\App\Http\Controllers\Backend\Auth\VerificationController::class, 'resend'])->name('admin.verification.resend');


});


Route::get('/category/{slug}', [IndexController::class, 'category'])->name('frontend.category.post');
Route::get('/archive/{date}', [IndexController::class, 'archive'])->name('frontend.archive.post');
Route::get('/author/{username}', [IndexController::class, 'author'])->name('frontend.author.post');

Route::get('/search', [IndexController::class, 'search'])->name('frontend.search');
Route::get('/contact-us', [IndexController::class, 'contact'])->name('frontend.contact');
Route::post('/contact-us', [IndexController::class, 'do_contact'])->name('frontend.do_contact');
Route::get('/{post}', [IndexController::class, 'post_show'])->name('post.show');
Route::post('/{post}', [IndexController::class, 'store_comment'])->name('post.add_comment');
