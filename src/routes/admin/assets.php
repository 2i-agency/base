<?php

/*
 * Ассеты админцентра
 */

Route::get('css/{filename}', 'AssetController@css');
Route::get('js/{directory}/{filename}', 'AssetController@js');
Route::get('img/{filename}', 'AssetController@img');