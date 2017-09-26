<?php

/**
 * Добавление уведомления администратора
 *
 * @param string $content
 * @param string $type
 */
function notice($content, $type = NULL, $users_ids = NULL){
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
	$attributes = [
		'content' => $content,
		'type_id' => $type
	];

	$notice = new \Chunker\Base\Models\Notice($attributes);

	if (isset($users_ids) && count($users_ids)) {
		$notice->users_ids = $users_ids;
	}

	$notice->save();
}