<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AfdelingController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\DocumentDeletionRequestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DeletedDocumentController;
use App\Http\Controllers\SpkPpbjController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.alias');
    Route::resource('archives', ArchiveController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('documents', DocumentController::class);
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::resource('users', UserController::class);
    Route::resource('divisions', DivisionController::class);
    Route::resource('afdelings', AfdelingController::class);
    // Document deletion requests
    Route::get('documents/{document}/deletion-request', [DocumentDeletionRequestController::class, 'create'])->name('document-deletion-requests.create');
    Route::post('documents/{document}/deletion-request', [DocumentDeletionRequestController::class, 'store'])->name('document-deletion-requests.store');
    Route::get('document-deletion-requests', [DocumentDeletionRequestController::class, 'index'])->name('document-deletion-requests.index');
    Route::post('document-deletion-requests/{deletionRequest}/process', [DocumentDeletionRequestController::class, 'process'])->name('document-deletion-requests.process');

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    // Deleted documents
    Route::get('deleted-documents', [DeletedDocumentController::class, 'index'])->name('deleted-documents.index');
    
    // SPK & PPBJ
    Route::resource('spk-ppbj', SpkPpbjController::class);
    Route::post('spk-ppbj/{spkPpbj}/approve', [SpkPpbjController::class, 'approve'])->name('spk-ppbj.approve');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
