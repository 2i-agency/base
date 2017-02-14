<?php
namespace Chunker\Base\ViewComposers;


use Illuminate\Contracts\View\View;

class ActivityLogComposer
{
	public function compose(View $view) {
		$actions = [
			'created'      => [
				'icon' => 'plus',
				'name' => 'Создание'
			],
			'updated'      => [
				'icon' => 'pencil',
				'name' => 'Редактирование'
			],
			'deleted'      => [
				'icon' => 'trash',
				'name' => 'Удаление'
			],
			'auth-error'   => [
				'icon' => 'sign-in',
				'name' => 'Провал аутентификации'
			],
			'auth-success' => [
				'icon' => 'sign-in',
				'name' => 'Успешная аутентификация'
			]
		];


		$view->with('actions', $actions);
	}

}