@extends('base::template')


@section('page.title', 'Типы уведомлений')


@section('page.content')

	<h3>Типы уведомлений</h3>

	{{--Форма добавления--}}
	@can('notices-types.edit')
		<form method="POST" class="panel panel-default" action="{{ route('admin.notices-types.store') }}">
			{!! csrf_field() !!}

			<div class="panel-heading">
				<div class="panel-title">Новый тип уведомлений</div>
			</div>

			<div class="panel-body">
				<div class="row">

					<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
						<input
							type="text"
							name="name"
							placeholder="Название типа"
							class="form-control"
							required
							autocomplete="off"
							autofocus
							value="{{ old('name') }}"
						>
					</div>

					<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
						@include('base::utils.buttons.add', ['block' => true])
					</div>

				</div>
			</div>

		</form>
	@endcan


	{{--Список типов уведомлений--}}
	@if ($notices_types->count())

		<form
			method="POST"
			class="panel panel-default table-responsive"
			action="{{ route('admin.notices-types.save') }}"
		>
			{!! csrf_field() !!}
			{!! method_field('PUT') !!}

			<table class="table table-striped table-hover">
				<tbody>

					@foreach($notices_types as $notices_type)
						<tr class="vertical-middle">

							<td>
								@can('notices-types.edit')
									{{--Поле ввода названия--}}
									<input
										type="text"
										name="notices_types[{{ $notices_type->id }}][name]"
										required
										autocomplete="off"
										value="{{ old('notices_types.' . $notices_type->id . '.name') ?: $notices_type->name }}"
										class="form-control{{ $notices_type->trashed() ?  ' deleted' : NULL }}"
										{{ is_null($notices_type->tag) && !$notices_type->trashed() ? NULL : 'disabled' }}
									>
								@else
									{{--Вывод названия--}}
									{{ $notices_type->name }}
								@endcan
							</td>

							{{--Удаление/Восстановление--}}
							@can('notices-types.admin')
								<td class="w1px">
									<div class="form-control-static">
										<label class="checkbox-inline">
											@if($notices_type->trashed())
												@include('base::utils.buttons.restore', [
													'url' => route('admin.notices-types.restore', $notices_type),
												])
											@else
												<input
													type="checkbox"
													name="delete[]"
													value="{{ $notices_type->id }}"
													{{ is_null($notices_type->tag) ? NULL : 'disabled' }}
												>Удалить
											@endif
										</label>
									</div>
								</td>
							@endcan

						</tr>
					@endforeach

				</tbody>
			</table>

			{{--Кнопка сохранения--}}
			@can('notices-types.edit')
				<div class="panel-footer">
					@include('base::utils.buttons.save')
				</div>
			@endcan

		</form>

	@else

		{{--Типы уведомлений отсутствуют--}}
		@include('base::utils.alert', ['message' => 'Типы уведомлений отсутствуют'])

	@endif

@stop