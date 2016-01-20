<?php

namespace Chunker\Base\Events;

use App\Events\Event;
use Chunker\Base\Models\User;

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