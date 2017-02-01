<?php
namespace Chunker\Base;

use Illuminate\Auth\Access\Gate as BaseGate;
use Illuminate\Database\Eloquent\Model;

class Gate extends BaseGate
{
	/**
	 * Get the raw result for the given ability for the current user.
	 *
	 * @param  string  $ability
	 * @param  array|mixed  $arguments
	 * @return mixed
	 */
	protected function raw($ability, $arguments = [])
	{
		/** Кусок из стандартного Gate */
		if (! $user = $this->resolveUser()) {
			return false;
		}

		/** Если передана модель, проверяется доступ к этой модели */
		if ( $user->hasAbility($ability, $arguments)) {
			return true;
		}

		/** Если переданы массив или коллекция, то пройтись по ним и проверить доступ отдельной модели */
		if (count($arguments)) {
			foreach ($arguments as $argument) {
				if ($argument instanceof Model && $user->hasAbility($ability, $argument)) {
					return true;
				}
			}
		}

		/** Проверка из стандартного Gate */
		$arguments = is_array($arguments) ? $arguments : [$arguments];

		if (is_null($result = $this->callBeforeCallbacks($user, $ability, $arguments))) {
			$result = $this->callAuthCallback($user, $ability, $arguments);
		}

		$this->callAfterCallbacks(
			$user, $ability, $arguments, $result
		);

		return $result;
	}
}