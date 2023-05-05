<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["prefix" => "v1/auth"], function(){
    Route::post("registro", [AuthController::class, "registrar"]);
    Route::post("login", [AuthController::class, "ingresar"]);

    Route::group(["middleware" => "auth:sanctum"],function(){
        Route::get("perfil", [AuthController::class, "getPerfil"]);
        Route::post("logout", [AuthController::class, "salir"]);
    });
});

Route::group(["middleware" => "auth:sanctum"],function(){
    Route::apiResource("categoria", CategoriaController::class);
    Route::apiResource("usuario", UsuarioController::class);
    Route::apiResource("producto", ProductoController::class);
    Route::apiResource("pedido", PedidoController::class);
    Route::apiResource("cliente", ClienteController::class);
    Route::apiResource("persona", PersonalController::class);
});
