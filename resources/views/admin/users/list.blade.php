@extends('chunker.base::admin.template')


@section('page.title', 'Пользователи')


@section('page.content')

	<h3>Пользователи</h3>

	{{--Ссылка на страницу добавления пользователя--}}
	<div class="mb20px">
		<a href="{{ route('admin.users.create') }}" class="btn btn-default">
			<span class="fa fa-plus"></span>
			Добавление пользователя
		</a>
	</div>


	@if ($users->count())

		{{--Список пользователей--}}
		<div class="panel panel-default table-responsive">
			<table class="table table-striped table-hover">

				<thead>
				<tr>
					<th>Логин</th>
					<th>Электропочта</th>
					<th>Имя</th>
					<th>Уведомления</th>
					<th>Роли</th>
					<th>Последняя авторизация</th>
					<th></th>
				</tr>
				</thead>

				<tbody>
				@foreach($users as $user)
					<tr>

						{{--Логин--}}
						@if ($user->is_blocked)
							<td class="text-muted">
								<span class="fa fa-ban" data-hover="tooltip" data-placement="right" title="Пользователь заблокирован"></span>
								{{ $user->login }}
							</td>
						@else
							<td>{{ $user->login }}</td>
						@endif

						{{--Электронный адрес--}}
						<td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>

						{{--Имя--}}
						@if ($user->name)
							<td>{{ $user->name }}</td>
						@else
							<td class="text-muted">Имя не указано</td>
						@endif

						{{--Уведомления--}}
						@if ($user->is_subscribed)
							<td>Получает уведомления</td>
						@else
							<td>Не&nbsp;получает уведомления</td>
						@endif

						@if ($user->roles()->count())
							<td>{{ implode(', ', $user->roles->lists('name')->toArray()) }}</td>
						@else
							<td class="text-muted">Нет ролей</td>
						@endif

						{{--Время последней авторизации--}}
						@if ($user->authentications()->count())
							<td>{{ $user->authentications()->recent()->first(['logged_in_at'])->logged_in_at }}</td>
						@else
							<td class="text-muted">Пока не авторизовывался</td>
						@endif

						{{--Ссылка на страницу редактирования--}}
						<td class="text-right">
							@include('chunker.base::admin.utils.edit', ['element' => $user])
							<a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-xs">
								<span class="fa fa-pencil"></span>
								Редактировать
							</a>
						</td>

					</tr>
				@endforeach
				</tbody>

			</table>
		</div>

	@else

		{{--Уведомление об отсутствии пользователей--}}
		@include('chunker.base::admin.utils.alert', ['message' => 'Пользователи отсутствуют'])

	@endif

@stop