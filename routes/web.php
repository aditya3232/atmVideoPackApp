<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormSimController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserMcuController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\SettingUserController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\McuController;
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

Route::get('/', function () {
    // return view('welcome');
    return redirect('/login');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'role:admin,admin pendaftaran sidik jari,fresh']], function() {
//     Route::get('/', [AdminController::class, 'index'])->name('index');
//     Route::post('/datatabletotalcardmcu', [AdminController::class, 'dataTableTotalCardMcu'])->name('datatabletotalcardmcu');
// });

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
Route::group(['prefix' => 'admin/permissions', 'as' => 'admin.permissions.', 'middleware' => ['auth', 'roleHasPermission:sidebar permissions']], function() {
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

// user mcu
Route::group(['prefix' => 'admin/usermcu', 'as' => 'admin.usermcu.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent master data']], function() {
    Route::get('/', [UserMcuController::class, 'index'])->name('index');
    Route::post('/datatable', [UserMcuController::class, 'dataTable'])->name('datatable');
    Route::get('/detail/{id}', [UserMcuController::class, 'detail'])->name('detail');
    Route::get('/edit/{id}', [UserMcuController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [UserMcuController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [UserMcuController::class, 'destroy'])->name('destroy');
    Route::get('/pdf/{id}', [UserMcuController::class, 'pdf'])->name('pdf');
    Route::get('/create', [UserMcuController::class, 'create'])->name('create');
    Route::post('/store', [UserMcuController::class, 'store'])->name('store');
    Route::post('/select2office', [UserMcuController::class, 'select2Office'])->name('select2office');
});

// office
Route::group(['prefix' => 'admin/office', 'as' => 'admin.office.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent master data']], function() {
    Route::get('/', [OfficeController::class, 'index'])->name('index');
    Route::post('/datatable', [OfficeController::class, 'dataTable'])->name('datatable');
    Route::post('/datatablemcuinthisoffice/{officeId}', [OfficeController::class, 'dataTableMcuInThisOffice'])->name('datatablemcuinthisoffice');
    Route::get('/detail/{id}', [OfficeController::class, 'detail'])->name('detail');
    Route::get('/edit/{id}', [OfficeController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [OfficeController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [OfficeController::class, 'destroy'])->name('destroy');
    Route::get('/pdf/{id}', [OfficeController::class, 'pdf'])->name('pdf');
    Route::get('/create', [OfficeController::class, 'create'])->name('create');
    Route::post('/store', [OfficeController::class, 'store'])->name('store');
    Route::post('/select2mcuineditoffice', [OfficeController::class, 'select2McuInEditOffice'])->name('select2mcuineditoffice');
    Route::post('/assignmcuinoffice/{id}', [OfficeController::class, 'assignMcuInOffice'])->name('assignmcuinoffice');
});

// log
Route::group(['prefix' => 'admin/log', 'as' => 'admin.log.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent log accept reject']], function() {
    Route::get('/accepted', [LogController::class, 'indexAccepted'])->name('indexaccepted');
    // Route::get('/rejected', [LogController::class, 'indexRejected'])->name('indexrejected');
    Route::post('/datatable/accepted', [LogController::class, 'dataTableAccepted'])->name('datatableaccepted');
    Route::post('/datatable/rejected', [LogController::class, 'dataTableRejected'])->name('datatablerejected');
    Route::post('/select2entryinlogaccepted', [LogController::class, 'select2EntryInLogAccepted'])->name('select2entryinlogaccepted');
    Route::post('/select2usernamemcuinlogaccepted', [LogController::class, 'select2UsernameMcuInLogAccepted'])->name('select2usernamemcuinlogaccepted');
    Route::post('/select2officeinlogaccepted', [LogController::class, 'select2OfficeInLogAccepted'])->name('select2officeinlogaccepted');
    Route::post('/select2doortokeninlogaccepted', [LogController::class, 'select2DoorTokenInLogAccepted'])->name('select2doortokeninlogaccepted');


});

// setting user
Route::group(['prefix' => 'admin/settinguser', 'as' => 'admin.settinguser.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent setting door lock']], function() {
    Route::get('/', [SettingUserController::class, 'index'])->name('index');
    Route::post('/datatable', [SettingUserController::class, 'dataTable'])->name('datatable');
    Route::get('/detail/{id}', [SettingUserController::class, 'detail'])->name('detail');
    Route::get('/edit/{id}', [SettingUserController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [SettingUserController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [SettingUserController::class, 'destroy'])->name('destroy');
    Route::get('/pdf/{id}', [SettingUserController::class, 'pdf'])->name('pdf');
    Route::post('/blockuser/{id}', [SettingUserController::class, 'blockUser'])->name('blockuser');
    Route::post('/unblockuser/{id}', [SettingUserController::class, 'unblockUser'])->name('unblockuser');
    Route::post('/assignmcu/{user_mcu_id}', [SettingUserController::class, 'assignMcu'])->name('assignmcu');
    Route::delete('/deletemcu/{tb_entry_id}/{tb_mcu_id}', [SettingUserController::class, 'deleteMcu'])->name('deletemcu');
    Route::post('/select2entryinsettinguser', [SettingUserController::class, 'select2EntryInSettingUser'])->name('select2entryinsettinguser'); // select2 card / entry
    Route::post('/select2usernamecardinsettinguser', [SettingUserController::class, 'select2UsernameMcuInSettingUser'])->name('select2usernamecardinsettinguser'); // select2 username_card
    Route::post('/select2kantorinsettinguser', [SettingUserController::class, 'select2KantorInSettingUser'])->name('select2kantorinsettinguser'); // select2 office
    Route::post('/select2entry/{officeId}', [SettingUserController::class, 'select2Entry'])->name('select2entry');
    Route::post('/select2entryvisitor/{officeId}', [SettingUserController::class, 'select2EntryVisitor'])->name('select2entryvisitor');
});

// card
Route::group(['prefix' => 'admin/card', 'as' => 'admin.card.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent setting door lock']], function() {
    Route::get('/', [CardController::class, 'index'])->name('index');
    Route::post('/datatable', [CardController::class, 'dataTable'])->name('datatable');
    Route::get('/create', [CardController::class, 'create'])->name('create');
    Route::post('/store', [CardController::class, 'store'])->name('store');
    Route::get('/detail/{id}', [CardController::class, 'detail'])->name('detail');
    Route::get('/edit/{id}', [CardController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [CardController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [CardController::class, 'destroy'])->name('destroy');
    Route::get('/pdf/{id}', [CardController::class, 'pdf'])->name('pdf');
    Route::post('/select2mcu/{office_id}/{card_id}', [CardController::class, 'select2Mcu'])->name('select2mcu');
    Route::post('assignmcu/{id}', [CardController::class, 'assignMcu'])->name('assignmcu');
    Route::delete('/deletemcu/{tb_entry_id}/{tb_mcu_id}', [CardController::class, 'deleteMcu'])->name('deletemcu');

});

// mcu
Route::group(['prefix' => 'admin/mcu', 'as' => 'admin.mcu.', 'middleware' => ['auth', 'roleHasPermission:sidebar parent setting door lock']], function() {
    Route::get('/', [McuController::class, 'index'])->name('index');
    Route::post('/datatable', [McuController::class, 'dataTable'])->name('datatable');
    Route::get('/create', [McuController::class, 'create'])->name('create');
    Route::post('/store', [McuController::class, 'store'])->name('store');
    Route::get('/detail/{id}', [McuController::class, 'detail'])->name('detail');
    Route::get('/edit/{id}', [McuController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [McuController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [McuController::class, 'destroy'])->name('destroy');
    Route::get('/pdf/{id}', [McuController::class, 'pdf'])->name('pdf');
});



require __DIR__.'/auth.php';