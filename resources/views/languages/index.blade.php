@extends('chunker.base::template')


@section('page.assets')
	<script src="{{ asset('admin/js/base/positioned.js') }}"></script>
	<script src="{{ asset('admin/js/base/languages.js') }}"></script>
@stop


@section('page.content')

	<h3>Языки</h3>


	{{--Форма добавления языка--}}
	<form method="POST" action="{{ route('admin.languages.store') }}" class="panel panel-default">
		{!! csrf_field() !!}

		<div class="panel-heading">
			<h4 class="panel-title">Новый язык</h4>
		</div>

		<div class="panel-body">
			<div class="row">

				{{--Название--}}
				<div class="col-lg-5">
					<input
						type="text"
						name="name"
						autofocus
						required
						autocomplete="off"
						placeholder="Название"
						class="form-control"
					>
				</div>

				{{--Псевдоним--}}
				<div class="col-lg-5">
					<input
						type="text"
						name="route_key"
						autocomplete="off"
						placeholder="Псевдоним"
						class="form-control"
					>
				</div>

				{{--Кнопка добавления--}}
				<div class="col-lg-2">
					@include('chunker.base::_utils.buttons.add', ['block' => true])
				</div>

			</div>
		</div>
	</form>


	{{--Список языков--}}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">Добавленные языки</h4>
		</div>
		<table class="table">
			<thead>
				<tr>
					<th>Название</th>
					<th>Псевдоним</th>
					<th>Публикация</th>
					<th></th>
				</tr>
			</thead>
			<tbody class="positioned" data-url="{{ route('admin.languages.positioning') }}">
				@foreach ($languages as $language)
					<tr data-id="{{ $language->id }}">

						{{--Название--}}
						<td>{{ $language->name }}</td>

						{{--Псевдоним--}}
						<td>{{ $language->route_key }}</td>

						{{--Публикация--}}
						@if ($language->is_published)
							<td>Опубликован</td>
						@else
							<td class="text-muted">Не опубликован</td>
						@endif

						{{--Кнопка редактирования--}}
						<td class="text-right">
							<button
								type="button"
								class="btn btn-primary btn-xs"
								data-toggle="modal"
								data-target="#modal-edit"
								data-action_update="{{ route('admin.languages.update', $language) }}"
								data-name="{{ $language->name }}"
								data-route_key="{{ $language->route_key }}"
								data-is_published="{{ $language->is_published }}">
								<span class="glyphicon glyphicon-pencil"></span>
								Редактировать
							</button>
						</td>

					</tr>
				@endforeach
			</tbody>
		</table>
	</div>


	{{--Модальное окно редактирования языка--}}
	<form method="POST" class="modal fade" id="modal-edit">
		{!! method_field('PUT') !!}
		{!! csrf_field() !!}

		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<h4 class="modal-title">Редактирование языка</h4>
				</div>

				<div class="modal-body">

					{{--Название--}}
					<div class="form-group">
						<label>Название:</label>
						<input type="text" name="name" autocomplete="off" required class="form-control">
					</div>

					{{--Псевдоним--}}
					<div class="form-group">
						<label>Псевдоним:</label>
						<input type="text" name="route_key" autocomplete="off" class="form-control">
					</div>

					{{--Флаг публикации--}}
					<div class="form-group">
						<label>Опубликован:</label>
						<div>
							<label class="radio-inline">
								<input type="radio" name="is_published" value="1"> Да
							</label>
							<label class="radio-inline">
								<input type="radio" name="is_published" value="0"> Нет
							</label>
						</div>
					</div>

					{{--Кнопка сохранения--}}
					@include('chunker.base::_utils.buttons.save')

				</div>

			</div>
		</div>

	</form>

@stop