@extends('base::template')


@section('page.title', 'Языки')


@section('page.assets')
	<script src="{{ asset('admin/js/languages.js') }}"></script>
@stop


@section('page.content')
	@php($_icon_small = config('chunker.localization.icon.size.small'))
	@php($_icon_big   = config('chunker.localization.icon.size.big'))
	<h3>Языки</h3>

	{{--Форма добавления языка--}}
	@can('languages.edit')
		<form
			method="POST"
			action="{{ route('admin.languages.store') }}"
			class="panel panel-default"
			enctype="multipart/form-data"
		>
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

				{{--Файл иконки--}}
				@if(config('chunker.localization.icon.using'))
					<div class="form-group">
						<input type="file" name="icon">
					</div>
				@endif

				{{--Кнопка добавления--}}
				<div class="form-group">
					@include('base::utils.buttons.add')
				</div>

				<div class="help-block">
					Локаль можно не указывать — в этом случае она будет сгенерирована на основе названия. Локаль может
					содержать буквы, цифры, дефис и нижнее подчёркивание.
				</div>

			</div>

		</form>
	@endcan


	{{--Список языков--}}
	<div class="panel panel-default">

		<div class="table-responsive">
			<table class="table table-striped table-hover">

				<thead>
				<tr>
					<th>Название</th>
					<th>Локаль</th>
					<th>Публикация</th>
					<th class="w1px"></th>
				</tr>
				</thead>

				<tbody class="js-positionable" data-url="{{ route('admin.languages.positioning') }}">
				@foreach ($languages as $language)
					<tr data-id="{{ $language->id }}">

						{{--Название--}}
						<td>
							@if(config('chunker.localization.icon.using') && $language->getMedia()->count())
								<img src="{{ $language->getMedia()->first()->getUrl($_icon_small) }}">
							@endif
							{{ $language->name }}
						</td>

						{{--Локаль--}}
						<td>{{ $language->locale }}</td>

						{{--Публикация--}}
						@if ($language->is_published)
							<td>Опубликован</td>
						@else
							<td class="text-muted">Не опубликован</td>
						@endif

						{{--Кнопка редактирования--}}
						<td class="text-right text-nowrap">
							@include('base::utils.edit', ['element' => $language])
							@can('languages.edit')
								<button
									type="button"
									class="btn btn-primary btn-xs"
									data-toggle="modal"
									data-target="#modal-edit"
									data-action_update="{{ route('admin.languages.update', $language) }}"
									data-name="{{ $language->name }}"
									data-locale="{{ $language->locale }}"
									data-is_published="{{ $language->is_published }}"
									data-flag="{{ (config('chunker.localization.icon.using') && $language->getMedia()->count()) ?
											$language->getMedia()->first()->getUrl($_icon_small) :
											''
										}}"
								>
									<span class="glyphicon glyphicon-pencil"></span>
									Редактировать
								</button>
							@endcan
						</td>

					</tr>
				@endforeach
				</tbody>

			</table>
		</div>

	</div>


	{{--Модальное окно редактирования языка--}}
	@can('languages.edit')
		<form method="POST" class="modal fade" id="modal-edit" enctype="multipart/form-data">
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

						{{--Файл флага--}}
						@if(config('chunker.localization.icon.using'))
							<div class="form-group">
								<label for="language-flag">Иконка</label><br>
								<img class="js-flag-modal hidden" src=""> <input type="file" id="language-flag" name="icon">
							</div>
						@endif
						<div class="checkbox js-flag-modal hidden">
							<label>
								<input type="checkbox" name="delete_icon"> Удалить иконку
							</label>
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
						@include('base::utils.buttons.save')

					</div>

				</div>
			</div>

		</form>
	@endcan

@stop