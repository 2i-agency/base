<?php

namespace Chunker\Base\Models\Traits\BelongsTo;

/**
 * Трейт для подключения связей с пользователями,
 * создающими и обновляющими модель
 *
 * @package Chunker\Base\Models\Traits\BelongsTo
 */
trait BelongsToEditors
{
	use BelongsToCreator, BelongsToUpdater;
}