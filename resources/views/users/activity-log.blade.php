@extends('base::template')


@section('page.title', 'Аудит действий пользователя ' . $user->getName())


@section('page.content')

	{{--Хлебные крошки--}}
	@include('base::users._breadcrumbs')

	{{--Табы--}}
	@include('base::users._tabs')

	{{--Список уведомлений--}}
	@if ($activities->count())
		{{--Пагинатор--}}
		{!! $activities->render() !!}

		<div class="panel panel-default">
			<div class="table-responsive">
				<table class="table table-striped table-hover">

					<tbody>
					@foreach ($activities as $activity)
						<tr class="{{ isset($actions[$activity->log_name]) ? $actions[$activity->log_name] : NULL }}">

							{{--Описание--}}
							<td>{{ $activity->description }}</td>

							{{--Время--}}
							<td class="text-right">{{ $activity->created_at }}</td>

						</tr>
					@endforeach
					</tbody>

				</table>
			</div>
		</div>

		{{--Пагинатор--}}
		{!! $activities->render() !!}

	@else

		{{--Уведомления отсутствуют--}}
		@include('base::utils.alert', ['message' => 'Действия отсутствуют'])

	@endif

@stop