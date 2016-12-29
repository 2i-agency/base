@extends('chunker.base::template')


@section('page.title', 'Аутентификации пользователя ' . $user->getName())


@section('page.content')

	{{--Хлебные крошки--}}
	@include('chunker.base::users._breadcrumbs')

	{{--Табы--}}
	@include('chunker.base::users._tabs')

	@if ($authentications->count())

		{{--Список аутентификаций--}}
		<div class="panel panel-default table-responsive">
			<table class="table table-striped table-hover">

				<thead>
					<th>Начало</th>
					<th>Последнее действие</th>
					<th style="min-width: 100px;">IP-Адрес</th>
					<th>Браузер</th>
					<th>Операционная система</th>
					<th style="width: 50px;">Статус</th>
				</thead>

				<tbody>
					@foreach($authentications as $authentication)

						{{--Окрашивание строки в соответствии со статусом аутентификации--}}
						@if ($is_current = ($authentication->last_request_at && $authentication->last_request_at->eq(\Carbon\Carbon::now())))
							<tr class="info">
						@elseif ($authentication->is_failed)
							<tr class="danger">
						@else
							<tr>
						@endif

							{{--Время аутентификации--}}
							<td>{{ $authentication->logged_in_at }}</td>

							{{--Время аутентификации--}}
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

							{{--Браузер--}}
							<td>
								{{ $authentication->getBrowser()->getName() }}
								{{ $authentication->getBrowser()->getVersion() }}
							</td>

							{{--Операционная система--}}
							<td>
								{{ $authentication->getOs()->getName() }}
								{{ $authentication->getOs()->getVersion() }}
							</td>

							{{--Статус аутентификации--}}
							@if ($authentication->is_failed)
								<td><span class="label label-danger">Провалена</span></td>
							@else
								<td><span class="label label-success">Успешна</span></td>
							@endif

						</tr>
					@endforeach
				</tbody>

			</table>
		</div>

		{{--Пагинатор--}}
		{!! $authentications->render() !!}

	@else

		{{--Уведомление об отсутствии аутентификаций--}}
		@include('chunker.base::utils.alert', ['message' => 'Пользователь пока не производил аутентификаций'])

	@endif

@stop