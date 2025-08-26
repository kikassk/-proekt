<?php


use App\Controllers\CartController;




/*
 * Main file for creating a routing map.
 * Routes are recalculated when files in this folder are changed (with the 'routes.auto-update' parameter set).
 * To force updates of the routes cache, you need to run "php console --routes-upd".
 * Since the route map is cached, dynamically changing data is not applicable here.
 *
 * Основной файл для создания карты маршрутизации.
 * Маршруты обновляются при изменении файлов в этой папке (при установленном параметре 'routes.auto-update').
 * Для принудительного обновления кеша маршрутов необходимо выполнить «php console --routes-upd».
 * Так как карта маршрутов хранится в кеше, здесь не применимы динамически изменяющиеся данные.
 */

Route::get('/', view('default'))->name('homepage');

// API для корзины

Route::get('/api/v1/cart')->controller(CartController::class, 'getCart')->name('api.cart.get');
Route::post('/api/v1/cart/add')->controller(CartController::class, 'addProduct')->name('api.cart.add');
Route::patch('/api/v1/cart/item/{itemId}')->controller(CartController::class, 'updateQuantity')->name('api.cart.update');
Route::delete('/api/v1/cart/item/{itemId}')->controller(CartController::class, 'removeItem')->name('api.cart.remove');
