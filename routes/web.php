<?php

use App\Livewire\PushNotification;
use Illuminate\Support\Facades\Route;
use App\Livewire\EditionManager;
use App\Livewire\HikeManager;

use App\Livewire\GroupManager;
use App\Livewire\ParticipantManager;
use App\Livewire\PostManager;
use App\Livewire\ShowPost;
use App\Livewire\GroupCheckIn;
use App\Livewire\PointAssignment;
use App\Livewire\Dashboard;
use App\Livewire\HikePointsOverview;
use App\Livewire\UserManager;
use App\Livewire\RolePermissionManager;
use App\Livewire\MomentUpload;
use App\Livewire\UserProfile;
use App\Livewire\EditMoment;
use App\Livewire\GoogleCloudUploader;




Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/test', function () {
    return view('test');
})->name('test');

Route::get('/profile', function () {
    return view('profile.profilepage');
})->name('profilepage');

Route::get('/profile/{user}', UserProfile::class)->name('profile');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

//Routes voor app
Route::get('/edition-manager', EditionManager::class)->name('edition-manager');

Route::get('/hike-manager/{editionId}', HikeManager::class)->name('hike-manager');

Route::get('/group-manager/{hikeId}', GroupManager::class)->name('group-manager');

Route::get('/participant-manager/{groupId}', ParticipantManager::class)->name('participant-manager');
Route::get('/post-manager/{hikeId}', PostManager::class)->name('post-manager');
Route::get('/post/{postId}', ShowPost::class)->name('post.show');
Route::get('/group-check-in/{postId}', GroupCheckIn::class)->name('group-check-in');
Route::get('/point-assignment/{postId}', PointAssignment::class)->name('point-assignment');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/hike-dashboard', Dashboard::class)->name('hike-dashboard');
});


Route::get('/hike/{hikeId}/points-overview', HikePointsOverview::class)->name('hike.points-overview');

//Route::middleware(['auth:sanctum', 'verified'])->group(function () {
//    Route::get('/admin', function () {
//        return view('admin');
//    })->name('admin');
//});


//role middleware
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin', function () {
        return view('admin');
    })->name('admin');
   // Route::get('/push', function () {    
    //    return view('livewire.push-notification');})->name('push');
    Route::get('/push', PushNotification::class)->name('push');
});



//role middleware
Route::group(['middleware' => ['can:manage permissions']], function () {
    Route::get('/roles-permissions', RolePermissionManager::class)->name('roles-permissions');
});



//https://spatie.be/docs/laravel-permission/v6/basic-usage/middleware  documentatie
Route::group(['middleware' => ['can:manage users']], function () {
    Route::get('/user-management', UserManager::class)->name('user.management');
});


Route::group(['middleware' => ['can:post moments']], function () {
    //Moments Routes:
    Route::get('/upload-moment', MomentUpload::class)->name('upload-moment');
    Route::get('/moment/{momentId}/edit', [MomentController::class, 'edit'])->name('edit-moment');
    Route::post('/moment/{momentId}', [MomentController::class, 'update'])->name('update-moment');
    
});
Route::group(['middleware' => ['can:view map']], function () {
Route::get('/kaart', function () {    
    return view('map');})->name('kaart');
});

Route::group(['middleware' => ['role:admin']], function () {
Route::get('phpinfo', function () {
    phpinfo(); 
})->name('phpinfo');
});

//polling for new feed
// routes/web.php
Route::get('/check-new-moments', function () {
    $user = Auth::user();
    $lastFeedCheck = $user->last_feed_check;
    
    $newMoments = \App\Models\Moment::where('created_at', '>', $lastFeedCheck)->count();

    return response()->json(['new_moments' => $newMoments > 0]);
});



Route::get('/upload-to-gcs', GoogleCloudUploader::class);
