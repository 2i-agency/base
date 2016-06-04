<ul class="breadcrumb">
	<li><a href="{{ route('admin.users') }}">Пользователи</a></li>
	<li class="active">{{ isset($user) ? $user->getName() : 'Добавление пользователя' }}</li>
</ul>