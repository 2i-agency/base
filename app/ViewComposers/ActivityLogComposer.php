<?php
namespace Chunker\Base\ViewComposers;


use Illuminate\Contracts\View\View;

class ActivityLogComposer
{
	public function compose(View $view){
		$actions = [
			'created'  => 'plus',
			'updated'  => 'pencil',
			'deleted'  => 'trash',
			'restored' => 'reply',
			'error'    => 'exclamation-circle'
		];


		$view->with('actions', $actions);
	}

}