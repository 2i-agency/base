{{--Табы--}}
@include('base::utils.tabs', [
	'tabs' => [
		'<span class="fa fa-user"></span> Данные' => route('users.edit', $user),
		'<span class="fa fa-key"></span> Аутентификации' => route('users.authentications', $user)
	]
])