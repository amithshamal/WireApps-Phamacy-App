<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\MedicationController;
use Symfony\Component\HttpFoundation\Response;

Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"]);

// Protected Routes
Route::group([
    "middleware" => ["auth:sanctum"]
], function () {

    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index']);
        Route::post('/', [CustomerController::class, 'store']);
        Route::get('{customer}', [CustomerController::class, 'show'])->missing(function (Request $request) {
            return response()->json(['status' => false, 'message' => "Customer not found"], Response::HTTP_NOT_FOUND);
        });
        Route::put('{customer}', [CustomerController::class, 'update'])->missing(function (Request $request) {
            return response()->json(['status' => false, 'message' => "Customer not found"], Response::HTTP_NOT_FOUND);
        });
        Route::delete('{customer}', [CustomerController::class, 'destroy'])->missing(function (Request $request) {
            return response()->json(['status' => false, 'message' => "Customer not found"], Response::HTTP_NOT_FOUND);
        });
    });

    Route::prefix('medications')->group(function () {
        Route::get('/', [MedicationController::class, 'index']);
        Route::post('/', [MedicationController::class, 'store']);
        Route::get('{medication}', [MedicationController::class, 'show'])->missing(function (Request $request) {
            return response()->json(['status' => false, 'message' => "Medication not found"], Response::HTTP_NOT_FOUND);
        });
        Route::put('{medication}', [MedicationController::class, 'update'])->missing(function (Request $request) {
            return response()->json(['status' => false, 'message' => "Medication not found"], Response::HTTP_NOT_FOUND);
        });
        Route::delete('{medication}', [MedicationController::class, 'destroy'])->missing(function (Request $request) {
            return response()->json(['status' => false, 'message' => "Medication not found"], Response::HTTP_NOT_FOUND);
        });
    });


    Route::get("logout", [AuthController::class, "logout"]);
    Route::get("refresh-token", [AuthController::class, "refreshToken"]);
});
