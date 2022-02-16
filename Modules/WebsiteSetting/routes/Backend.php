<?php

// website setting
Route::group(['prefix' => 'website'], function() {
    Route::view('/header', 'backend.website_settings.header')->name('website.header');
    Route::view('/footer', 'backend.website_settings.footer')->name('website.footer');
    Route::view('/pages', 'backend.website_settings.pages.index')->name('website.pages');
    Route::view('/appearance', 'backend.website_settings.appearance')->name('website.appearance');
    Route::resource('custom-pages', '\Modules\WebsiteSetting\Controllers\PageController');
    Route::get('/custom-pages/edit/{id}', '\Modules\WebsiteSetting\Controllers\PageController@edit')->name('custom-pages.edit');
    Route::get('/custom-pages/destroy/{id}', '\Modules\WebsiteSetting\Controllers\PageController@destroy')->name('custom-pages.destroy');
});
