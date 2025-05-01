<?php

use App\Http\Controllers\Auth\Admin\DashboardController;
use App\Http\Controllers\Auth\Admin\EmployeeController;
use App\Http\Controllers\Auth\Admin\PayrollController;
use App\Http\Controllers\Auth\Admin\ShiftController;
use App\Http\Controllers\Auth\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Auth\User\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
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
    if (Auth::check()) {
        return redirect(Auth::user()->role === 'admin' ? '/admin/dashboard' : '/user/dashboard');
    }
    return redirect('/login'); // Redirect to login if not authenticated
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('auth','role:admin')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // employee routes

    Route::get('/employee/list', [EmployeeController::class, 'index'])->name('admin.employee.list');
    Route::get('/employee/add', [EmployeeController::class, 'add'])->name('admin.employee.add');
    Route::post('/employee/create', [EmployeeController::class, 'create'])->name('admin.employee.create');
    Route::post('/employee/delete', [EmployeeController::class, 'delete'])->name('admin.employee.delete');
    Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('admin.employee.edit');
    Route::post('/employee/update', [EmployeeController::class, 'update'])->name('admin.employee.update');


    // shifts routes
    Route::get('/shift/add', [ShiftController::class, 'add'])->name('admin.shift.add');
    Route::post('/shift/create', [ShiftController::class, 'create'])->name('admin.shift.create');
    Route::post('/shift/delete', [ShiftController::class, 'delete'])->name('admin.shift.delete');
    Route::get('/shift/edit/{id}', [ShiftController::class, 'edit'])->name('admin.shift.edit');
    Route::post('/shift/update', [ShiftController::class, 'update'])->name('admin.shift.update');
    Route::get('/shift/list', [ShiftController::class, 'index'])->name('admin.shift.list');


    //attendance routes
    Route::get('/shift/today', [ShiftController::class, 'todayList'])->name('admin.shift.today');
    Route::get('/shift/pending', [ShiftController::class, 'pendingList'])->name('admin.shift.pending');
    Route::get('/shift/attendance/{id}', [ShiftController::class, 'attendance'])->name('admin.shift.attendance');
    Route::post('/shift/checkedinout/', [ShiftController::class, 'checkedinout'])->name('admin.shift.checkedinout');


    //payroll routes
    Route::get('/payroll/list', [PayrollController::class, 'index'])->name('admin.payroll.list');
    Route::get('/payroll/add', [PayrollController::class, 'add'])->name('admin.payroll.add');
    Route::post('/payroll/create', [PayrollController::class, 'create'])->name('admin.payroll.create');
    Route::post('/payroll/delete', [PayrollController::class, 'delete'])->name('admin.payroll.delete');
    Route::get('/payroll/edit/{id}', [PayrollController::class, 'edit'])->name('admin.payroll.edit');
    Route::post('/payroll/update', [PayrollController::class, 'update'])->name('admin.payroll.update');


});

Route::middleware('auth','role:user')->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

    Route::get('/shifts/all', [UserController::class, 'shiftsList'])->name('user.shifts.all');
    Route::get('/payrolls/all', [UserController::class, 'payrollsList'])->name('user.payrolls.all');
});


require __DIR__.'/auth.php';
