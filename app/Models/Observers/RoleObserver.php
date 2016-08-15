<?php

namespace Chunker\Base\Models\Observers;

use Chunker\Base\Models\Role;

class RoleObserver
{
	public function deleting(Role $role) {

		// Удаление связей с возможностями
		$role->abilities()->detach();

		// Удаление связей с типами уведомлений
		$role->noticesTypes()->detach();

		// Удаление связей с пользователями
		$role->users()->detach();

	}
}