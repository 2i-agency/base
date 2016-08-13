<?php

namespace Chunker\Base\Policies;

use Chunker\Base\Models\Notice;
use Chunker\Base\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NoticePolicy
{
	use HandlesAuthorization;


	public function edit(User $user, Notice $notice = NULL) {
		return $user->isHasAbility('notices.edit');
	}
}
