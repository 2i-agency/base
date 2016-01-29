<ul class="breadcrumb">

	<li><a href="{{ route('admin.users') }}">Пользователи</a></li>

	@if (isset($user))
		<li class="active">{{ $user->getName() }}</li>
	@else
		<li class="active">Добавление пользователя</li>
	@endif

</ul>