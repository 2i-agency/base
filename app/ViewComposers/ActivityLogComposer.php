<?php
namespace Chunker\Base\ViewComposers;


use Illuminate\Contracts\View\View;

class ActivityLogComposer
{
	public function compose(View $view) {
		$actions = [
			'created'      => 'plus',
			'updated'      => 'pencil',
			'deleted'      => 'trash',
			'restored'     => 'reply',
			'auth-error'   => 'exclamation-circle',
			'auth-success' => 'check-circle'
		];


		$view->with('actions', $actions);
	}

}