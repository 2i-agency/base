@extends('chunker.base::admin.template')


@section('page.title', 'Языки')


@section('page.assets')
	<script src="{{ asset('admin/js/base.js') }}"></script>
	<script src="{{ asset('admin/js/languages.js') }}"></script>
@stop


@section('page.content')

	<h3>Языки</h3>


	{{--Форма добавления языка--}}
	<form method="POST" action="{{ route('admin.languages.store') }}" class="panel panel-default">
		{!! csrf_field() !!}

		<div class="panel-heading">
			<h4 class="panel-title">Новый язык</h4>
		</div>

		<div class="panel-body form-inline">

			{{--Название--}}
			<div class="form-group">
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

			{{--Локаль--}}
			<div class="form-group">
				<input
					type="text"
					name="locale"
					pattern="^[\da-z][\da-z-]*[\da-z]$"
					minlength="2"
					autocomplete="off"
					placeholder="Локаль"
					class="form-control"
				>
			</div>

			{{--Кнопка добавления--}}
			<div class="form-group">
				@include('chunker.base::admin.utils.buttons.add')
			</div>

			<div class="help-block">Локаль можно не указывать — в этом случае он будет сгенерирован на основе названия. Локаль может содержать буквы, цифры, дефис и нижнее подчёркивание.</div>

		</div>

	</form>


	{{--Список языков--}}
	<div class="panel panel-default">

		<div class="panel-heading">
			<h4 class="panel-title">Добавленные языки</h4>
		</div>

		<div class="table-responsive">
			<table class="table table-striped table-hover">

				<thead>
					<tr>
						<th>Название</th>
						<th>Локаль</th>
						<th>Публикация</th>
						<th></th>
					</tr>
				</thead>

				<tbody class="positioned" data-url="{{ route('admin.languages.positioning') }}">
					@foreach ($languages as $language)
						<tr data-id="{{ $language->id }}">

							{{--Название--}}
							<td>{{ $language->name }}</td>

							{{--Локаль--}}
							<td>{{ $language->locale }}</td>

							{{--Публикация--}}
							@if ($language->is_published)
								<td>Опубликован</td>
							@else
								<td class="text-muted">Не опубликован</td>
							@endif

							{{--Кнопка редактирования--}}
							<td class="text-right">
								@include('chunker.base::admin.utils.edit', ['element' => $language])
								<button
									type="button"
									class="btn btn-primary btn-xs"
									data-toggle="modal"
									data-target="#modal-edit"
									data-action_update="{{ route('admin.languages.update', $language) }}"
									data-name="{{ $language->name }}"
									data-locale="{{ $language->locale }}"
									data-is_published="{{ $language->is_published }}"
								>
									<span class="glyphicon glyphicon-pencil"></span>
									Редактировать
								</button>
							</td>

						</tr>
					@endforeach
				</tbody>

			</table>
		</div>

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
						<input
							type="text"
							name="name"
							autocomplete="off"
							required
							class="form-control"
						>
					</div>

					{{--Локаль--}}
					<div class="form-group">
						<label>Локаль:</label>
						<input
							type="text"
							name="locale"
							autocomplete="off"
							class="form-control"
							pattern="^[\da-z][\da-z-]*[\da-z]$"
							minlength="2"
						>
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
					@include('chunker.base::admin.utils.buttons.save')

				</div>

			</div>
		</div>

	</form>

@stop