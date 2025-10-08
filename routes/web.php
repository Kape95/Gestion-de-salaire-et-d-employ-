<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\SalaireController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\ConfigurationController;



Route::get('/',[AuthController::class, 'login'])->name('login');  
Route::post('/', [AuthController::class, 'handleLogin'])->name('handleLogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// route securisé

 Route::middleware('auth')->group(function(){

     Route::get('/dashboard',[AppController::class, 'index'])->name('dashboard');
     




     
 Route::prefix('employers')->group(function(){
    Route::get('/', [EmployerController::class, 'index'])->name('employers.index');
    Route::get('/create', [EmployerController::class, 'create'])->name('employers.create');
    Route::get('/edit/{employer}', [EmployerController::class, 'edit'])->name('employers.edit');
   
   //  Route d'action

    Route::put('/update/{employer}', [EmployerController::class, 'update'])->name('employers.update');
      Route::delete('/delete/{employer}', [EmployerController::class, 'delete'])->name('employers.delete');

    Route::post('/store', [EmployerController::class, 'store'])->name('employers.store');
    
 });

 Route::prefix('Departements')->group(function(){
    Route::get('/', [DepartementController::class, 'index'])->name('departements.index');
    Route::get('/create', [DepartementController::class, 'create'])->name('departements.create');
     Route::post('/store', [DepartementController::class, 'store'])->name('departements.store');
    Route::get('/edit/{departement}', [DepartementController::class, 'edit'])->name('departements.edit');


     Route::put('/update/{departement}', [DepartementController::class, 'update'])->name('departements.update',);

    Route::delete('/{departement}', [DepartementController::class, 'delete'])->name('departements.delete');
    
 });
 
 // Routes pour les salaires
 Route::prefix('salaires')->group(function(){
    Route::get('/', [SalaireController::class, 'index'])->name('salaires.index');
    Route::get('/payslip/{employer}', [SalaireController::class, 'generatePayslip'])->name('salaires.payslip');
    Route::get('/payslip/{employer}/pdf', [SalaireController::class, 'downloadPdf'])->name('salaires.download-pdf');
    Route::post('/payslip/{employer}/email', [SalaireController::class, 'sendEmail'])->name('salaires.send-email');
    Route::get('/bulk', [SalaireController::class, 'bulkGenerate'])->name('salaires.bulk');
 });
 
 // Routes pour les rapports
 Route::prefix('rapports')->group(function(){
    Route::get('/', [RapportController::class, 'index'])->name('rapports.index');
    Route::get('/departements', [RapportController::class, 'departements'])->name('rapports.departements');
    Route::get('/salaires', [RapportController::class, 'salaires'])->name('rapports.salaires');
 });
 
 // Routes pour la configuration
 Route::prefix('configuration')->group(function(){
    Route::get('/', [ConfigurationController::class, 'index'])->name('configuration.index');
    Route::get('/profile', [ConfigurationController::class, 'profile'])->name('configuration.profile');
    Route::put('/profile', [ConfigurationController::class, 'updateProfile'])->name('configuration.update-profile');
    Route::get('/users', [ConfigurationController::class, 'users'])->name('configuration.users');
    Route::get('/users/create', [ConfigurationController::class, 'createUser'])->name('configuration.create-user');
    Route::post('/users', [ConfigurationController::class, 'storeUser'])->name('configuration.store-user');
    Route::delete('/users/{id}', [ConfigurationController::class, 'deleteUser'])->name('configuration.delete-user');
    Route::get('/system', [ConfigurationController::class, 'system'])->name('configuration.system');
 });

 });






