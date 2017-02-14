{{--Табы--}}
@include('base::utils.tabs', [
	'tabs' => [
		'<span class="fa fa-user"></span> Данные' => route('admin.users.edit', $user),
		'<span class="fa fa-info"></span> Аудит действий' => route('admin.users.activity-log', $user),
		'<span class="fa fa-star"></span> Права' => route('admin.users.abilities', $user)
	]
])