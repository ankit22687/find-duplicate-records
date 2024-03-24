<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MergeRecordsController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('doctors.index');
});

Route::get('/find-duplicate-records/{type}', [
    MergeRecordsController::class, 'findDuplicateRecords',
])->name('find_duplicate_records');

Route::post('/merge-duplicate-records', [
    MergeRecordsController::class, 'mergeDuplicateRecords',
])->name('merge_duplicate_records');
Route::resource('doctors', DoctorController::class);

Route::resource('tests', TestController::class);
