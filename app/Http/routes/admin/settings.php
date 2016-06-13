<?php

/*
 * Настройки
 */

Route::controller('settings', 'SettingController', [
	'getIndex' => 'admin.settings'
]);