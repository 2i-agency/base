@extends('chunker.base::template')


@section('page.title', 'Уведомления')


@section('page.content')

	<h3>Уведомления</h3>


	{{--Форма поиска--}}
	<form class="panel panel-default">
		<div class="panel-body">
			<div class="row">

				{{--Тип--}}
				@if ($notices_types->count())
					<div class="col-lg-3 col-md-2 col-sm-6 col-xs-12">
						<select name="type" class="form-control">
							<option value="all"{{ Request::get('type') == 'all' ? ' selected' : NULL }}>Любого типа</option>
							@foreach($notices_types as $notices_type)
								<option value="{{ $notices_type->id }}"{{ Request::get('type') == $notices_type->id ? ' selected' : NULL }}>{{ $notices_type->name }}</option>
							@endforeach
							<option value="none"{{ Request::get('type') == 'none' ? ' selected' : NULL }}>Без типа</option>
						</select>
					</div>
				@endif

				{{--Статус--}}
				<div class="
					col-lg-{{ $notices_types->count() ? 3 : 4 }}
					col-md-{{ $notices_types->count() ? 2 : 4 }}
					col-sm-{{ $notices_types->count() ? 6 : 12 }}
					col-xs-12
				">
					<select name="is_read" class="form-control">
						<option value="all"{{ Request::get('is_read') == 'all' ? ' selected' : NULL }}>Прочитанные и непрочитанные</option>
						<option value="read"{{ Request::get('is_read') == 'read' ? ' selected' : NULL }}>Прочитанные</option>
						<option value="not_read"{{ Request::get('is_read') == 'not_read' ? ' selected' : NULL }}>Непрочитанные</option>
					</select>
				</div>

				{{--С--}}
				<div class="
					col-lg-{{ $notices_types->count() ? 2 : 3 }}
					col-md-{{ $notices_types->count() ? 3 : 3 }}
					col-sm-6
					col-xs-12
				">
					<div class="input-group datetime js-timepicker">
						<input
							type="text"
							class="form-control"
							name="since"
							placeholder="С"
						    value="{{ Request::get('since') }}"
						    autocomplete="off"
						>
						<span class="input-group-addon">
							<span class="fa fa-calendar"></span>
						</span>
					</div>
				</div>

				{{--По--}}
				<div class="
					col-lg-{{ $notices_types->count() ? 2 : 3 }}
					col-md-{{ $notices_types->count() ? 3 : 3 }}
					col-sm-6
					col-xs-12
				">
					<div class="input-group datetime js-timepicker">
						<input
							type="text"
							class="form-control"
							name="until"
							placeholder="По"
							value="{{ Request::get('until') }}"
							autocomplete="off"
						>
						<span class="input-group-addon">
							<span class="fa fa-calendar"></span>
						</span>
					</div>
				</div>

				<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
					<button type="submit" class="btn btn-primary btn-block">
						<span class="fa fa-search"></span>
						Показать
					</button>
				</div>

			</div>
		</div>
	</form>


	{{--Список уведомлений--}}
	@if ($notices->count())

		{{--Пагинатор--}}
		{!! $notices->render() !!}

		<div class="panel panel-default">
			<div class="table-responsive">
				<table class="table table-striped table-hover">

					<thead>
						<tr>
							<th class="text-right" style="width: 1px;">№</th>
							<th style="width: 150px;">Время</th>
							<th>Содержимое</th>
							<th class="w1px">Тип</th>
							@can('notices.edit')
								<th class="w1px"></th>
							@endcan
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
								<td>{!! $notice->content !!}</td>

								{{--Тип--}}
								<td class="text-nowrap">
									@if ($notice->type)
										{{ $notice->type->name }}
									@else
										<span class="text-muted">Без типа</span>
									@endif
								</td>

								{{--Кнопки--}}
								@can('notices.edit')
									<td class="text-right text-nowrap">
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
											@include('chunker.base::utils.buttons.delete', [
												'size' => 'xs',
												'url' => route('notices.destroy', ['notice' => $notice])
											])

										</form>

									</td>
								@endcan

							</tr>
						@endforeach
					</tbody>

				</table>
			</div>
		</div>

		{{--Пагинатор--}}
		{!! $notices->render() !!}

	@else

		{{--Уведомление--}}
		@include('chunker.base::utils.alert', ['message' => 'Уведомления отсутствуют'])

	@endif

@stop