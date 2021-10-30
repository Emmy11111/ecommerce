<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/register", [RegisterController::class, "index"]);
Route::post("/register", [RegisterController::class, "register_user"])->name("register.user");
Route::get("/login", [AuthController::class, "index"]);
Route::post("/login", [AuthController::class, "auth"])->name("auth.user");

Route::get("/add_product", [ProductController::class, "index"]);

Route::post("/add_product", [ProductController::class, "add_product"])->name("add.product");

Route::get("/logout", [AuthController::class, "logout"]);
Route::get("/profiles", [ProfileController::class, "index"]);
Route::post("/profiles", [ProfileController::class, "uploadProfile"])->name("upload.profile");

Route::get("/products/all/price/{cond}", [HomeController::class, "price"]);

// Route::get("/products/{districts}", [HomeController::class, "district"]);

Route::get("/products/all/type/{type}/{item}/{cond}", [HomeController::class, "types"]);
Route::get("/products/all/type/{type}/{item}/{cond}/{district}", [HomeController::class, "district"]);
Route::get("/products/all/kigali/type/{type}/{item}/{cond}", [ProductController::class, "productsKgl"]);

Route::post("/products/all/type/{type}/{item}/{cond}", [SearchController::class, "search"])->name("search.products");

Route::get("/products/all", [ProductController::class, "allProducts"]);
Route::get("/products/all/{id}", [ProductController::class, "deleteProduct"]);
Route::get("/products/update/{id}", [ProductController::class, "editProduct"]);

Route::post("/products/update/{id}", [ProductController::class, "update_product"])->name("edit.product");