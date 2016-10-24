<h3>{{ $title }}</h3>
@can($ability_edit)

	{{--Форма добавления элемента--}}
	<form method="POST" action="{{ route($route['store']) }}" class="panel panel-default">
		{!! csrf_field() !!}
		{!! method_field('PUT') !!}

		<div class="panel-heading">
			<h4 class="panel-title">{{ $title_new }}</h4>
		</div>

		<div class="panel-body row">

			<div class="col-xs-6 col-sm-9 col-md-10">
				<input
						type="text"
						name="name"
						value="{{ old('name') }}"
						autofocus
						required
						autocomplete="off"
						placeholder="Название"
						class="form-control"
				>
			</div>

			<div class="col-xs-6 col-sm-3 col-md-2 text-right">
				<button type="submit" class="btn btn-block btn-primary">
					<span class="glyphicon glyphicon-plus"></span>
					Добавить
				</button>
			</div>

		</div>

	</form>

@endcan

@if($directory->count())

	{{--Список--}}
	<form method="POST" action="{{ route($route['save']) }}" class="panel panel-default">
		{!! method_field('PUT') !!}

		<div class="table-responsive">
			<table class="table table-hover">

				{{--Отключение позиционирование при отсутствии прав на редактирование--}}
				@can($ability_edit)
					<tbody class="js-positionable" data-url="{{ route($route['positioning']) }}">
				@else
					<tbody>
					@endcan

					@foreach ($directory as $item)

						<tr data-id="{{ $item->id }}">

							@can($ability_edit)
								<td width="1px" style="vertical-align: middle">
									<div class="fa fa-reorder"></div>
								</td>
								<td>
									<input
											type="text"
											name="names[{{ $item->id }}]"
											value="{{ old('names.' . $item->id) ?: $item->name }}"
											required
											autocomplete="off"
											placeholder="Название"
											class="form-control"
									>
								</td>
								@if(isset($can_delete) && $can_delete)
									<td width="1px" style="vertical-align: middle;">
										<label class="radio-inline" style="white-space: nowrap;">
											<input
													type="checkbox"
													name="delete[{{ $item->id }}]"
											> Удалить
										</label>
									</td>
								@endif
								@if(isset($can_edit) && $can_edit)
									<td width="1px" style="vertical-align: middle;">

										{{--Кнопка редактирования--}}
										<a href="{{ route($route['edit'], $item->id) }}" class="btn btn-primary btn-xs">
											@can($ability_edit)
												<span class="fa fa-pencil"></span>
												Редактировать
											@else
												<span class="fa fa-eye"></span>
												Просмотр
											@endcan
										</a>

									</td>
								@endif
							@else
								<td>{{ old('names.' . $item->id) ?: $item->name }}</td>
							@endcan

						</tr>
					@endforeach

					</tbody>

			</table>
		</div>

		@can($ability_edit)
			<div class="panel-footer">
				<div class="form-group">
					@include('chunker.base::admin.utils.buttons.save')
				</div>
			</div>
		@endcan
	</form>

@else

	@include('chunker.base::admin.utils.alert', ['message' => $empty])

@endif