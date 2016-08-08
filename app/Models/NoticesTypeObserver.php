<?php

namespace Chunker\Base\Models\Observers;

use Chunker\Base\Models\NoticesType;

class NoticesTypeObserver
{
	public function deleting(NoticesType $noticesType) {
		// Очистка ключа типа у уведомлений
		$noticesType
			->notices()
			->update(['type_id' => NULL]);
	}
}