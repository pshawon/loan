<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\Admin\UsersController;
use App\Http\Controllers\Backend\Admin\LoanTypesController;
use App\Http\Controllers\Backend\Admin\LoanController;
use App\Http\Controllers\Backend\SuperAdmin\SuperAdminController;
use App\Http\Controllers\Backend\SuperAdmin\SuperAdminLoanController;



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
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    route ::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    route ::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    route ::post('/admin/update/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    route ::get('/admin/update/password', [AdminController::class, 'updatePassword'])->name('admin.password.update');
    route ::post('/admin/store/password', [AdminController::class, 'storePassword'])->name('admin.password.store');

    route ::get('/admin/all/users', [UsersController::class, 'allUsers'])->name('admin.all.users');
    route::delete('/admin/delete/{user}', [UsersController::class, 'deleteUser'])->name('delete.user');
    route::get('/admin/user/detail/{id}',[UsersController::class,'userDetail'])->name('user.detail');

    route::post('/admin/user/{id}/toggle-role', [UsersController::class, 'toggleRole'])->name('user.toggle-role');
    route::post('/admin/user/{id}/toggle-status', [UsersController::class, 'toggleStatus'])->name('user.toggle-status');

    route ::get('/admin/all/loan/types', [LoanTypesController::class, 'allLoanTypes'])->name('admin.all.loan-types');
    route ::post('/admin/add/loan_type', [LoanTypesController::class, 'addLoanTypes'])->name('admin.add.loan-types');
    route::delete('/admin/delete/loan_type/{loan_type}', [LoanTypesController::class, 'deleteLoanType'])->name('delete.loan_type');
    route ::get('/admin/loan-types/{id}/edit', [LoanTypesController::class, 'editLoanType'])->name('admin.edit.loan-type');
    route ::put('/admin/loan-types/{id}', [LoanTypesController::class, 'updateLoanType'])->name('admin.update.loan-type');


    route ::get('/admin/all/loan/applications', [LoanController::class, 'allLoanApplications'])->name('admin.all.loan-applications');
    route ::get('/admin/all/approved/loans', [LoanController::class, 'allApprovedLoans'])->name('admin.all.approved.loans');
    route::get('/admin/loan/detail/{id}',[LoanController::class,'loanDetail'])->name('loan.detail');
    route::post('/admin/loan/{id}/toggle-status', [LoanController::class, 'toggleStatus'])->name('loan.toggle-status');
    route::delete('/admin/loan/delete/{loan}', [LoanController::class, 'deleteLoanApplication'])->name('delete.loan.application');




});

Route::middleware(['auth', 'role:user'])->group(function () {
    route ::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    route ::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    route ::post('/user/update/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    route ::get('/user/update/password', [UserController::class, 'updatePassword'])->name('user.password.update');
    route ::post('/user/store/password', [UserController::class, 'storePassword'])->name('user.password.store');

    route ::get('/user/loan/application', [LoanController::class, 'loanApplication'])->name('user.loan.application');
    route ::post('/user/loan/store', [LoanController::class, 'loanStore'])->name('user.loan.store');
    route ::get('/user/approved/loan', [LoanController::class, 'approvedLoan'])->name('user.approved.loan');




});

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    route ::get('/super_admin/dashboard', [SuperAdminController::class, 'index'])->name('super_admin.dashboard');

    route ::get('/super_admin/profile', [SuperAdminController::class, 'profile'])->name('super_admin.profile');
    route ::post('/super_admin/update/profile', [SuperAdminController::class, 'updateProfile'])->name('super_admin.profile.update');
    route ::get('/super_admin/update/password', [SuperAdminController::class, 'updatePassword'])->name('super_admin.password.update');
    route ::post('/super_admin/store/password', [SuperAdminController::class, 'storePassword'])->name('super_admin.password.store');


    route ::get('/super_admin/all/users', [SuperAdminController::class, 'allUsers'])->name('super_admin.all.users');
    route::delete('/super_admin/delete/{user}', [SuperAdminController::class, 'deleteUser'])->name('delete.user');
    route::get('/super_admin/user/detail/{id}',[SuperAdminController::class,'userDetail'])->name('user.detail');
    route::post('/super_admin/user/{id}/toggle-role', [SuperAdminController::class, 'toggleRole'])->name('user.toggle-role');
    route::post('/super_admin/user/{id}/toggle-status', [SuperAdminController::class, 'toggleStatus'])->name('user.toggle-status');

    route ::get('/super_admin/all/loan/applications', [SuperAdminLoanController::class, 'allLoanApplications'])->name('super_admin.all.loan-applications');
    // route ::get('/super_admin/all/approved/loans', [SuperAdminController::class, 'allApprovedLoans'])->name('super_admin.all.approved.loans');
    // route::get('/super_admin/loan/detail/{id}',[SuperAdminController::class,'loanDetail'])->name('loan.detail');
    // route::post('/super_admin/loan/{id}/toggle-status', [SuperAdminController::class, 'toggleStatus'])->name('super_admin.toggle-status');
    // route::delete('/super_admin/loan/delete/{loan}', [SuperAdminController::class, 'deleteLoanApplication'])->name('super_admin.loan.application');







});

require __DIR__.'/auth.php';
