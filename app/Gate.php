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
		if (! $user = $this->resolveUser()) {
			return false;
		}

		if ($user->id == 1) {
			return true;
		}

		if ($arguments instanceof Model && $user->hasAbility($ability, $arguments)) {
			return true;
		}

		if (count($arguments)) {
			foreach ($arguments as $argument) {
				if ($argument instanceof Model && $user->hasAbility($ability, $argument)) {
					return true;
				}
			}
		}

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