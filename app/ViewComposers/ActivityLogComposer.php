<?php
namespace Chunker\Base\ViewComposers;


use Illuminate\Contracts\View\View;

class ActivityLogComposer
{
	public function compose(View $view){
		$actions = [
			'created'  => 'success',
			'updated'  => 'info',
			'deleted'  => 'warning',
			'restored' => 'success',
			'error'    => 'danger'
		];


		$view->with('actions', $actions);
	}

}