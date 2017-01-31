<h3>{{ $title }}</h3>
@can($ability['edit'])

	{{--Форма добавления элемента--}}
	<form method="POST" action="{{ route($route['store']) }}" class="panel panel-default">
		{!! csrf_field() !!}
		{!! method_field('PUT') !!}

		<div class="panel-heading">
			<h4 class="panel-title">{{ $title_new }}</h4>
		</div>

		<div class="panel-body row">

			<div class="col-xs-6 col-sm-9 col-md-10">
				{{--Название--}}
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
	<form
		method="POST"
		action="{{ route($route['save']) }}"
		class="panel panel-default"
	>
		{!! method_field('PUT') !!}

		<div class="table-responsive">
			<table class="table table-hover">

				{{--Отключение позиционирование при отсутствии прав на редактирование--}}
				@can($ability['edit'])
					<tbody class="js-positionable" data-url="{{ route($route['positioning']) }}">
				@else
					<tbody>
				@endcan

					@foreach ($directory as $item)

						<tr data-id="{{ $item->id }}">

							@can($ability['edit'])
								{{--Ячейка с иконкой для сортировки объектов--}}
								<td width="1px" style="vertical-align: middle">
									<div class="fa fa-reorder"></div>
								</td>
								{{--Название--}}
								<td>
									<input
										type="text"
										name="names[{{ $item->getKey() }}]"
										value="{{ old('names.' . $item->id) ?: $item->name }}"
										required
										autocomplete="off"
										placeholder="Название"
										class="form-control"
										{{ !$item->trashed() ? NULL : 'disabled' }}
									>
								</td>
								{{--Вывод кода для вставки в текст. Добавление каталога чего-либо (напр.: галереи) в статьи--}}
								<td width="1px" class="code_insert">
									@if(isset($code_insert) && $code_insert['using'])
										{{ $code_insert['message']['start'] . $item->id . $code_insert['message']['end'] }}
									@endif
								</td>
								{{--Флаг для удаления записи--}}
								@if(isset($can_delete) && $can_delete && !$item->trashed())
									<td width="1px" style="vertical-align: middle;">
										<label class="radio-inline" style="white-space: nowrap;">
											<input
												type="checkbox"
												name="delete[{{ $item->id }}]"
											> Удалить
										</label>
									</td>
								@endif
								{{--Кнопка для редактирования/просмотра записи при включении режима одиночного редактирования--}}
								@if(isset($can_edit) && $can_edit && !$item->trashed())
									<td width="1px" style="vertical-align: middle;">

										<a href="{{ route($route['edit'], $item) }}" class="btn btn-primary">
											@can($ability['edit'])
												<span class="fa fa-pencil"></span>
												Редактировать
											@else
												<span class="fa fa-eye"></span>
												Просмотр
											@endcan
										</a>

									</td>
								@elseif($item->trashed())
									<td width="1px" style="vertical-align: middle;">

										@include('base::utils.buttons.restore', [
											'url' => route($route['restore'], $item),
										])

									</td>
								@endif
							@else
								<td style="vertical-align: middle;">{{ old('names.' . $item->id) ?: $item->name }}</td>

								<td width="1px" style="vertical-align: middle;">

									<a href="{{ route($route['edit'], $item) }}" class="btn btn-primary">
										<span class="fa fa-eye"></span>
										Просмотр
									</a>

								</td>
							@endcan

						</tr>
					@endforeach

					</tbody>

			</table>
		</div>

		@can($ability['edit'])
			<div class="panel-footer">
				<div class="form-group">
					@include('base::utils.buttons.save')
				</div>
			</div>
		@endcan
	</form>

@else

	@include('base::utils.alert', ['message' => $empty])

@endif