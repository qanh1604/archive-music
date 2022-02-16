<?php

//Custom page
Route::get('/{slug}', '\Modules\WebsiteSetting\Controllers\PageController@show_custom_page')->name('custom-pages.show_custom_page');


