<?php

/*
 * Добавление уведомления администратора
 */

function notice($content) {
	\Chunker\Base\Models\Notice::create(['content' => $content]);
}