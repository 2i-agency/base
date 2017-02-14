{{--Список уведомлений--}}
@if ($activities->count())
	@php($filter_fields = ['published_since', 'published_until', 'log_name', 'user', 'element'])
	{{--Пагинатор--}}
	{!! $activities->appends(request()->only($filter_fields))->render() !!}

	<div class="panel panel-default">
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tbody>
				@foreach ($activities as $activity)
					<tr class="{{ $activity->log_name == 'auth-error' ? 'danger' : NULL }}">
						{{--Иконка--}}
						<td class="text-center w1px">
							@if(isset($actions[$activity->log_name]))
								<span
									{{--Подсказка--}}
									data-hover="tooltip"
									title="{{ $actions[$activity->log_name]['name'] }}"
									data-placement="right"

									class="fa fa-{{ $actions[$activity->log_name]['icon'] }}"
								></span>
							@endif
						</td>

						{{--Время--}}
						<td class="w1px text-nowrap">{{ $activity->created_at }}</td>

						{{--Описание--}}
						<td>{!! $activity->description  !!}</td>

					</tr>
				@endforeach
				</tbody>

			</table>
		</div>
	</div>

	{{--Пагинатор--}}
	{!! $activities->appends(request()->only($filter_fields))->render() !!}

@else

	{{--Уведомления отсутствуют--}}
	@include('base::utils.alert', ['message' => 'Действия отсутствуют'])

@endif