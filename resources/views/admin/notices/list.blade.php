@extends('chunker.base::admin.template')


@section('page.title', 'Уведомления')


@section('page.content')

	<h3>Уведомления</h3>


	@if ($notices->count())

		{!! $notices->render() !!}

		<div class="panel panel-default">
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th class="text-right" style="width: 1px;">№</th>
							<th style="width: 150px;">Время</th>
							<th>Содержимое</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($notices as $notice)
							<tr{!! $notice->is_read ? NULL : ' class="info"'!!}>

								{{--Ключ--}}
								<td class="text-right">{{ $notice->id }}</td>

								{{--Время--}}
								<td>{{ $notice->created_at }}</td>

								{{--Содержимое--}}
								<td>{{ $notice->content }}</td>

								{{--Кнопки--}}
								<td class="text-right">
									<form
										method="POST"
									action="{{ route('admin.notices.read', ['notice' => $notice]) }}"
									>
										{!! csrf_field() !!}
										{!! method_field('PUT') !!}

										{{--Кнопка отметки о прочтении--}}
										@unless($notice->is_read)
											<button type="submit" class="btn btn-xs btn-primary">
												<span class="fa fa-check"></span>
												Отметить прочитанным
											</button>
										@endunless

										{{--Кнопка удаления--}}
										@include('chunker.base::admin.utils.buttons.delete', [
											'size' => 'xs',
											'url' => route('admin.notices.destroy', ['notice' => $notice])
										])

									</form>

								</td>

							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>

		{!! $notices->render() !!}

	@else

		@include('chunker.base::admin.utils.alert', ['message' => 'Уведомления отсутствуют'])

	@endif

@stop