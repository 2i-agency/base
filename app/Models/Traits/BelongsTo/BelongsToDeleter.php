<?php

namespace Chunker\Base\Models\Traits\BelongsTo;

use Chunker\Base\Models\Ability;
use Chunker\Base\Models\User;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Трейт для подключения связи с пользователем, создавшем модель
 *
 * @package Chunker\Base\Models\Traits\BelongsTo
 */
trait BelongsToDeleter
{

	/**
	 * Пользователь-создатель
	 *
	 * @return Eloquement - связь с моделью User
	 */
	public function deleter() {
		return $this->belongsTo(User::class, 'deleter_id');
	}


	public function scopeWithDelete($query, $ability = NULL) {
		if (is_null($ability)) {
			$ability = $this->ability;
		}

		$ability = Ability::getAdminAbility($ability);

		if (
			\Auth::user()->hasAdminAccess($ability, $this)
			|| \Auth
				::user()
				->agents()
				->where('model_type', get_class($this))
				->where('ability_id', $ability)
				->count()
		) {
			return $query->withTrashed();
		}

		return $query;
	}


	public function scopeOnlyDelete($query, $ability = NULL) {
		if (is_null($ability)) {
			$ability = $this->ability;
		}

		$ability = Ability::getAdminAbility($ability);

		if (
			\Auth::user()->hasAdminAccess($ability, $this)
			|| \Auth
				::user()
				->agents()
				->where('model_type', get_class($this))
				->where('ability_id', $ability)
				->count()
		) {
			return $query->onlyTrashed();
		}

		/**
		 * Условие, которое в любом случае вернёт пустой запрос.
		 * Нужно для того, чтобы возвращать пустой запрос если нет разрешения.
		 */
		return $query->where('id', NULL);
	}


	public function withTrashed()
	{
		return $this->withDelete();
	}


	public static function bootBelongsToDeleter() {

		static::deleting(function($model) {
			$model
				->deleter()
				->associate(Auth::user())
				->save();
		});

		static::restoring(function($model) {
			$model
				->deleter()
				->dissociate()
				->save();
		});
	}
}