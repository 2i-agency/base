<ul class="breadcrumb">
	@can('users.view')
		<li><a href="{{ route('admin.users') }}">Пользователи</a></li>
	@endcan
	<li class="active">{{ isset($user) ? $user->getName() : 'Добавление пользователя' }}</li>
</ul>