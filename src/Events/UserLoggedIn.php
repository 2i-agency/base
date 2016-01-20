<?php

namespace Chunker\Admin\Events;

use App\Events\Event;
use Chunker\Admin\Models\User;

class UserLoggedIn extends Event
{
	public $user;
	public $failed;


	public function __construct(User $user, $failed)
	{
		$this->user = $user;
		$this->failed = $failed;
	}
}