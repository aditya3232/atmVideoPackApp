<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\HumanDetectionController;
use App\Http\Controllers\VandalDetectionController;
use App\Http\Controllers\StreamingCctvController;
use App\Http\Controllers\DownloadPlaybackController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\CctvController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RegionalOfficeController;
use App\Http\Controllers\KcSupervisiController;
use App\Http\Controllers\BranchController;



use Illuminate\Support\Facades\Route;

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

/*
- 'middleware' => ['auth', 'roleHasPermission:sidebar parent dashboard'] => data roleHasPermission itu ditmabahkan di table permissions
- middleware disini agar link dapat diakses, sedangkan middleware di sidebar agar link dapat ditampilkan
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect('/login');
});

// route error 403
Route::get('/403', function () {
    return view('errors.403');
})->name('403');

// route error 404
Route::get('/404', function () {
    return view('errors.404');
})->name('404');

// route error 500
Route::get('/500', function () {
    return view('errors.500');
})->name('500');

// route error 419
Route::get('/419', function () {
    return view('errors.419');
})->name('419');

// admin // dashboard
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent dashboard']], function() {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/datatabletotalcardmcu', [AdminController::class, 'dataTableTotalCardMcu'])->name('datatabletotalcardmcu');
});

// permissions
Route::group(['prefix' => 'admin/permissions', 'as' => 'admin.permissions.', 'middleware' => ['auth', 'roleHasPermission:sidebar child permissions']], function() {
    Route::get('/',[ PermissionController::class, 'index'])->name('index');
    Route::post('/datatable', [PermissionController::class, 'dataTable'])->name('datatable');
    Route::get('/create', [PermissionController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('edit');
    Route::post('/store', [PermissionController::class, 'store'])->name('store');
    Route::post('/update/{id}', [PermissionController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [PermissionController::class, 'destroy'])->name('destroy');
});

// roles
Route::group(['prefix' => 'admin/roles', 'as' => 'admin.roles.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent setting admin']], function() {
    Route::get('/', [RoleController::class, 'index'])->name('index');
    Route::post('/datatable', [RoleController::class, 'dataTable'])->name('datatable');
    Route::get('/create', [RoleController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
    Route::post('/store', [RoleController::class, 'store'])->name('store');
    Route::post('/update/{id}', [RoleController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [RoleController::class, 'destroy'])->name('destroy');
    Route::post('/select2permissions/{id}', [RoleController::class, 'select2Permissions'])->name('select2permissions');
    Route::post('assignpermissions/{id}', [RoleController::class, 'assignPermissions'])->name('assignpermissions');
    Route::delete('/deletepermissions/{role_id}/{permission_id}', [RoleController::class, 'deletePermissions'])->name('deletepermissions');
});

// users
Route::group(['prefix' => 'admin/users', 'as' => 'admin.users.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent setting admin']], function() {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::post('/datatable', [UserController::class, 'dataTable'])->name('datatable');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
    Route::post('/select2roles', [UserController::class, 'select2Roles'])->name('select2roles');
    Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
});

// setting profile
Route::group(['prefix' => 'admin/profiles', 'as' => 'admin.profiles.', 'middleware' => ['auth']], function() {
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::post('/update', [ProfileController::class, 'update'])->name('update');
});

// human detection
Route::group(['prefix' => 'admin/humandetection', 'as' => 'admin.humandetection.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent human detection']], function() {
    Route::get('/', [HumanDetectionController::class, 'index'])->name('index');
    Route::post('/datatable', [HumanDetectionController::class, 'dataTable'])->name('datatable');
    Route::get('/create', [HumanDetectionController::class, 'create'])->name('create');
    Route::post('/store', [HumanDetectionController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [HumanDetectionController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [HumanDetectionController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [HumanDetectionController::class, 'destroy'])->name('destroy');
});

// vandal detection
Route::group(['prefix' => 'admin/vandaldetection', 'as' => 'admin.vandaldetection.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent vandal detection']], function() {
    Route::get('/', [VandalDetectionController::class, 'index'])->name('index');
    Route::post('/datatable', [VandalDetectionController::class, 'dataTable'])->name('datatable');
    Route::get('/create', [VandalDetectionController::class, 'create'])->name('create');
    Route::post('/store', [VandalDetectionController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [VandalDetectionController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [VandalDetectionController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [VandalDetectionController::class, 'destroy'])->name('destroy');
});

// Streaming Cctv
Route::group(['prefix' => 'admin/streamingcctv', 'as' => 'admin.streamingcctv.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent streaming cctv']], function() {
    Route::get('/', [StreamingCctvController::class, 'index'])->name('index');
    Route::get('/streaming/{id}', [StreamingCctvController::class, 'streamingCctv'])->name('streaming');
    Route::post('/datatable', [StreamingCctvController::class, 'dataTable'])->name('datatable');
    Route::get('/create', [StreamingCctvController::class, 'create'])->name('create');
    Route::post('/store', [StreamingCctvController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [StreamingCctvController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [StreamingCctvController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [StreamingCctvController::class, 'destroy'])->name('destroy');
});

// Download Playback
Route::group(['prefix' => 'admin/downloadplayback', 'as' => 'admin.downloadplayback.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent download playback']], function() {
    Route::get('/', [DownloadPlaybackController::class, 'index'])->name('index');
    Route::post('/datatable', [DownloadPlaybackController::class, 'dataTable'])->name('datatable');
    Route::get('/create', [DownloadPlaybackController::class, 'create'])->name('create');
    Route::post('/store', [DownloadPlaybackController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [DownloadPlaybackController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [DownloadPlaybackController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [DownloadPlaybackController::class, 'destroy'])->name('destroy');
});

// Device
Route::group(['prefix' => 'admin/device', 'as' => 'admin.device.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent master device']], function() {
    Route::get('/', [DeviceController::class, 'index'])->name('index');
    Route::post('/datatable', [DeviceController::class, 'dataTable'])->name('datatable');
    Route::get('/create', [DeviceController::class, 'create'])->name('create');
    Route::post('/store', [DeviceController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [DeviceController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [DeviceController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [DeviceController::class, 'destroy'])->name('destroy');
    Route::post('/select2location', [DeviceController::class, 'select2Location'])->name('select2location');
});

// Location
Route::group(['prefix' => 'admin/location', 'as' => 'admin.location.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent master device']], function() {
    Route::get('/', [LocationController::class, 'index'])->name('index');
    Route::post('/datatable', [LocationController::class, 'dataTable'])->name('datatable');
    Route::get('/create', [LocationController::class, 'create'])->name('create');
    Route::post('/store', [LocationController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [LocationController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [LocationController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [LocationController::class, 'destroy'])->name('destroy');
    Route::post('/select2regionaloffice', [LocationController::class, 'select2RegionalOffice'])->name('select2regionaloffice');
    Route::post('/select2kcsupervisi', [LocationController::class, 'select2KcSupervisi'])->name('select2kcsupervisi');
    Route::post('/select2branch', [LocationController::class, 'select2Branch'])->name('select2branch');
});

// Regional Office
Route::group(['prefix' => 'admin/regionaloffice', 'as' => 'admin.regionaloffice.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent master device']], function() {
    Route::get('/', [RegionalOfficeController::class, 'index'])->name('index');
    Route::post('/datatable', [RegionalOfficeController::class, 'dataTable'])->name('datatable');
    Route::get('/create', [RegionalOfficeController::class, 'create'])->name('create');
    Route::post('/store', [RegionalOfficeController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [RegionalOfficeController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [RegionalOfficeController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [RegionalOfficeController::class, 'destroy'])->name('destroy');
});

// Kc Supervisi
Route::group(['prefix' => 'admin/kcsupervisi', 'as' => 'admin.kcsupervisi.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent master device']], function() {
    Route::get('/', [KcSupervisiController::class, 'index'])->name('index');
    Route::post('/datatable', [KcSupervisiController::class, 'dataTable'])->name('datatable');
    Route::get('/create', [KcSupervisiController::class, 'create'])->name('create');
    Route::post('/store', [KcSupervisiController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [KcSupervisiController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [KcSupervisiController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [KcSupervisiController::class, 'destroy'])->name('destroy');
});

// Branch
Route::group(['prefix' => 'admin/branch', 'as' => 'admin.branch.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent master device']], function() {
    Route::get('/', [BranchController::class, 'index'])->name('index');
    Route::post('/datatable', [BranchController::class, 'dataTable'])->name('datatable');
    Route::get('/create', [BranchController::class, 'create'])->name('create');
    Route::post('/store', [BranchController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [BranchController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [BranchController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [BranchController::class, 'destroy'])->name('destroy');
});





require __DIR__.'/auth.php';