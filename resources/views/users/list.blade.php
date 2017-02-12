@extends('base::template')


@section('page.title', 'Пользователи')


@section('page.content')

	<h3>Пользователи</h3>

	{{--Ссылка на страницу добавления пользователя--}}
	@can('users.edit')
		<div class="mb20px">
			<a href="{{ route('admin.users.create') }}" class="btn btn-default">
				<span class="fa fa-plus"></span>
				Добавление пользователя
			</a>
		</div>
	@endcan

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
					{{--<th>Роли</th>--}}
					<th>Последняя авторизация</th>
					<th class="w1px"></th>
				</tr>
				</thead>

				<tbody>
					@foreach($users as $user)
						<tr>

							{{--Логин--}}
							@if($user->is_blocked || !$user->isAdmin())
								<td class="text-muted">
							@else
								<td>
							@endif

							@if($user->is_blocked)
								<span
									class="fa fa-ban"
									data-hover="tooltip"
									data-placement="right"
									title="Пользователь заблокирован"
								></span>
							@endif

							@if(!$user->isAdmin())
								<span
									class="fa fa-user-times"
									data-hover="tooltip"
									data-placement="right"
									title="Нет доступа в админ-панель"
								></span>
							@endif
							{{ $user->login }}
							@if ($user->roles()->count() && isset($_role_active) && $_role_active)
								<p class="text-muted small">
									{{ implode(', ', $user->roles->lists('name')->toArray()) }}
								</p>
							@endif
						</td>

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

							{{--Время последней авторизации--}}
							@if ($user->authentications()->count())
								<td>{{ $user->authentications()->recent()->first(['logged_in_at'])->logged_in_at }}</td>
							@else
								<td class="text-muted">Пока не авторизовывался</td>
							@endif

							{{--Ссылка на страницу редактирования--}}
							<td class="text-right text-nowrap">

								<a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-xs">
									@can('users.edit')
										<span class="fa fa-pencil"></span>
										Редактировать
									@else
										<span class="fa fa-eye"></span>
										Просмотр
									@endcan
								</a>
							</td>

						</tr>
					@endforeach
				</tbody>

			</table>
		</div>

	@else

		{{--Уведомление об отсутствии пользователей--}}
		@include('base::utils.alert', ['message' => 'Пользователи отсутствуют'])

	@endif

@stop