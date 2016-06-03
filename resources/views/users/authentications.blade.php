@extends('chunker.base::template')


@section('page.title', 'Аутентификации пользователя «' . $user->getName() . '»')


@section('page.content')

	<h3>Аутентификации пользователя «{{ $user->getName() }}»</h3>

	{{--Хлебные крошки--}}
	@include('chunker.base::users._utils.breadcrumbs')

	{{--Табы--}}
	<ul class="nav nav-tabs">
		<li><a href="{{ route('admin.users.edit', $user) }}">Данные</a></li>
		<li class="active"><a href="{{ route('admin.users.authentications', $user) }}">Аутентификации</a></li>
	</ul>

	@if ($authentications->count())

		{{--Список авторизаций--}}
		<table class="table table-striped table-hover">

			<thead>
				<th>Начало</th>
				<th>Окончание</th>
				<th style="min-width: 100px;">IP-Адрес</th>
				<th>Идентификатор браузера</th>
				<th>Статус</th>
			</thead>

			<tbody>
				@foreach($authentications as $authentication)

					{{--Окрашивание строки в соответствии со статусом авторизации--}}
					@if ($is_current = ($authentication->last_request_at && $authentication->last_request_at->eq(\Carbon\Carbon::now())))
						<tr>
					@elseif ($authentication->is_failed)
						<tr class="danger">
					@else
						<tr>
					@endif

						{{--Время авторизации--}}
						<td>{{ $authentication->logged_in_at }}</td>

						{{--Время деавторизации--}}
						@if ($authentication->last_request_at)
							@if ($is_current)
								<td>Сеанс активен</td>
							@else
								<td>{{ $authentication->last_request_at }}</td>
							@endif
						@else
							<td class="text-muted">Сеанс не&nbsp;состоялся</td>
						@endif

						{{--IP-адрес--}}
						<td>{{ $authentication->ip_address }}</td>

						{{--Идентификатор браузера--}}
						<td>{{ $authentication->user_agent }}</td>

						{{--Статус авторизации--}}
						@if ($authentication->is_failed)
							<td><span class="label label-danger">Провалена</span></td>
						@else
							<td><span class="label label-success">Успешна</span></td>
						@endif

					</tr>
				@endforeach
			</tbody>

		</table>

		{{--Пагинатор--}}
		{!! $authentications->render() !!}

	@else

		{{--Уведомление об отсутствии авторизаций--}}
		@include('chunker.base::_utils.alert', ['message' => 'Пользователь пока не производил авторизаций'])

	@endif

@stop