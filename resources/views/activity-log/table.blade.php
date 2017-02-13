{{--Список уведомлений--}}
@if ($activities->count())

	{{--Пагинатор--}}
	{!! $activities->render() !!}

	<div class="panel panel-default">
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tbody>
				@foreach ($activities as $activity)
					<tr>
						@php($log_name = $activity->log_name)
						{{--Иконка--}}
						<td class="text-center w1px">
							<span class="fa fa-{{ isset($actions[$log_name]) ? $actions[$log_name] : NULL }}"></span>
						</td>

						{{--Время--}}
						<td class="w1px text-nowrap">{{ $activity->created_at }}</td>

						{{--Описание--}}
						<td>{{ $activity->description }}</td>

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