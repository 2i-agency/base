<?php

namespace Chunker\Base\Events;

use App\Events\Event;
use Chunker\Base\Models\User;

class UserRequestedApp extends Event
{
	public $user;


	public function __construct(User $user) {
		$this->user = $user;
	}
}