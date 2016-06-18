<?php

/*
 * Уведомления
 */

Route::controller('/', 'NoticeController', [
	'getIndex' => 'admin.notices',
	'putReadNotice' => 'admin.notices.read',
	'deleteDestroyNotice' => 'admin.notices.destroy'
]);