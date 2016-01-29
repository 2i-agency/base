@extends('Base::template')


@section('page.title', 'Авторизации пользователя «' . $user->getName() . '»')


@section('page.content')

	<h3>Авторизации пользователя «{{ $user->getName() }}»</h3>

	{{--Хлебные крошки--}}
	@include('Base::users._utils.breadcrumbs')

	{{--Табы--}}
	<ul class="nav nav-tabs">
		<li><a href="{{ route('admin.users.edit', $user) }}">Данные</a></li>
		<li class="active"><a href="{{ route('admin.users.authorizations', $user) }}">Авторизации</a></li>
	</ul>

	@if ($authorizations->count())

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
				@foreach($authorizations as $authorization)

					{{--Окрашивание строки в соответствии со статусом авторизации--}}
					@if ($is_current = ($authorization->last_request_at && $authorization->last_request_at->eq(\Carbon\Carbon::now())))
						<tr>
					@elseif ($authorization->failed)
						<tr class="danger">
					@else
						<tr>
					@endif

						{{--Время авторизации--}}
						<td>{{ $authorization->logged_in_at }}</td>

						{{--Время деавторизации--}}
						@if ($authorization->last_request_at)
							@if ($is_current)
								<td>Сеанс активен</td>
							@else
								<td>{{ $authorization->last_request_at }}</td>
							@endif
						@else
							<td class="text-muted">Сеанс не&nbsp;состоялся</td>
						@endif

						{{--IP-адрес--}}
						<td>{{ $authorization->ip_address }}</td>

						{{--Идентификатор браузера--}}
						<td>{{ $authorization->user_agent }}</td>

						{{--Статус авторизации--}}
						@if ($authorization->failed)
							<td><span class="label label-danger">Провалена</span></td>
						@else
							<td><span class="label label-success">Успешна</span></td>
						@endif

					</tr>
				@endforeach
			</tbody>

		</table>

		{{--Пагинатор--}}
		{!! $authorizations->render() !!}

	@else

		{{--Уведомление об отсутствии авторизаций--}}
		@include('Base::_utils.alert', ['message' => 'Пользователь пока не производил авторизаций'])

	@endif

@stop