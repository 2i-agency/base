<?php

/*
 * Ассеты админцентра
 */

Route::get('css/{filename}', 'AssetController@css');
Route::get('js/{directory}/{filename}', 'AssetController@js');