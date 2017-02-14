<?php

/**
 * Добавление уведомления администратора
 *
 * @param string $content
 * @param string $type
 */
function notice($content, $type = NULL){
	if (is_object($type)) {
		$type = $type->id;
	} else {
		if (is_string($type)) {
			$type = \Chunker\Base\Models\NoticesType::where('tag', $type)->first([ 'id' ])->id;
		} else {
			if ($type) {
				$type = (int)$type;
			}
		}
	}

	\Chunker\Base\Models\Notice::create([
		'content' => $content,
		'type_id' => $type
	]);
}