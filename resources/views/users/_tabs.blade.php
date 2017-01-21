{{--Табы--}}
@include('base::utils.tabs', [
	'tabs' => [
		'<span class="fa fa-user"></span> Данные' => route('admin.users.edit', $user),
		'<span class="fa fa-key"></span> Аутентификации' => route('admin.users.authentications', $user)
	]
])