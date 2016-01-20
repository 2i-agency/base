<?php

namespace Chunker\Admin\Events;

use App\Events\Event;
use Chunker\Admin\Models\User;

class UserRequestedApp extends Event
{
	public $user;


	public function __construct(User $user)
	{
		$this->user = $user;
	}
}