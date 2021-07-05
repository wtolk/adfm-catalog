<?php

Route::prefix('/admin')->middleware(['web', 'auth'])->namespace('App\Http\Controllers\Admin')->group(function () {

    /* Категории товаров */

    Route::get('/categories', 'CategoryController@index')->name('adfm.categories.index');
    Route::get('/categories/create', 'CategoryController@create')->name('adfm.categories.create');
    Route::post('/categories', 'CategoryController@store')->name('adfm.categories.store');
    Route::get('/categories/{id}/edit', 'CategoryController@edit')->name('adfm.categories.edit');
    Route::match(['put', 'patch'],'/categories/{id}', 'CategoryController@update')->name('adfm.categories.update');
    Route::delete('/categories/{id}', 'CategoryController@destroy')->name('adfm.categories.destroy');

    /* Товары */

    Route::get('/products', 'ProductController@index')->name('adfm.products.index');
    Route::get('/products/create', 'ProductController@create')->name('adfm.products.create');
    Route::post('/products', 'ProductController@store')->name('adfm.products.store');
    Route::get('/products/{id}/edit', 'ProductController@edit')->name('adfm.products.edit');
    Route::match(['put', 'patch'],'/products/{id}', 'ProductController@update')->name('adfm.products.update');
    Route::delete('/products/{id}', 'ProductController@destroy')->name('adfm.products.destroy');

    /* Заказы */

    Route::get('/orders', 'OrderController@index')->name('adfm.orders.index');
    Route::get('/orders/{id}/show', 'OrderController@show')->name('adfm.orders.show');
    Route::delete('/orders/{id}', 'OrderController@destroy')->name('adfm.orders.destroy');

});

Route::group(['namespace' => 'App\Http\Controllers\Site', 'middleware' => ['web']], function () {
    Route::get('/catalog', 'CatalogController@showCatalog')->name('adfm.show.catalog');
    Route::get('/catalog/category/{category:slug}', 'CatalogController@showCategory')->name('adfm.show.category');
    Route::get('catalog/{product}', 'CatalogController@showProduct')->name('adfm.show.product');

    Route::get('/ordering', 'CatalogController@showOrdering')->name('adfm.show.ordering');
    Route::post('/ordering', '\App\Http\Controllers\Admin\OrderController@store')->name('adfm.order.store');
    Route::view('/ordering/success', 'adfm::public.catalog.ordering-success')->name('adfm.success.ordering');
});
