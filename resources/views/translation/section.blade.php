@extends('base::template')


@section('page.title', $title)


@section('page.content')

	{{--Хлебные крошки--}}
	<ul class="breadcrumb">
		<li><a href="{{ route('admin.translation') }}">Разделы интерфейса</a></li>
		<li class="active">{{ $title }}</li>
	</ul>

	{{--Список элементов--}}
	<form method="POST" class="panel panel-default" action="{{ route('admin.translation.save', $section) }}">
		{!! csrf_field() !!}
		{!! method_field('PUT') !!}

		<div class="panel-heading">
			<h4 class="panel-title">Элементы раздела</h4>
		</div>

		<div class="panel-body">

			{{--Поля--}}
			@foreach ($fields as $field)
				<div class="form-group">
					<label>{{ $field['title'] }}:</label>

					@can('translation.edit')

						{{--Текстовое поле--}}
						@if ($field['type'] == 'textarea')
							<textarea
								name="elements[{{ $field['name'] }}]"
								class="form-control"
								rows="5"
							>{{ $field['value'] }}</textarea>

						{{--Поле ввода--}}
						@else
							<input
								type="{{ $field['type'] }}"
								name="elements[{{ $field['name'] }}]"
								class="form-control"
								value="{{ $field['value'] }}"
								autocomplete="off">
						@endif

					@else

						<p class="form-control-static">
							@if (strlen($field['value']))
								{{ $field['value'] }}
							@else
								<span class="text-muted">Не заполнено</span>
							@endif
						</p>

					@endcan

				</div>
			@endforeach

		</div>

		@can('translation.edit')
			<div class="panel-footer">
				{{--Кнопка сохранения--}}
				@include('base::utils.buttons.save')
			</div>
		@endcan

	</form>

@stop