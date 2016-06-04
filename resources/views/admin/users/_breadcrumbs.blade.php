<ul class="breadcrumb">
	<li>
		<span class="fa fa-list"></span>
		<a href="{{ route('admin.users') }}">Пользователи</a>
	</li>
	<li class="active">
		@if (isset($user))
			<span class="fa fa-pencil"></span>
			{{ $user->getName() }}
		@else
			<span class="fa fa-plus"></span>
			Добавление пользователя
		@endif
	</li>
</ul>