@extends('Base::template')


@section('page.title', 'Перевод интерфейса')


@section('page.content')

	<h3>Перевод интерфейса</h3>

	<div class="panel panel-default">

		<div class="panel-heading">
			<h4 class="panel-title">Разделы интерфейса</h4>
		</div>

		{{--Список разделов--}}
		<ul class="list-group">
			@foreach(config('languages.localization') as $section_name => $section_data)
				<li class="list-group-item">
					<a href="{{ route('admin.translation.section', $section_name) }}">{{ $section_data[0] }}</a>
				</li>
			@endforeach
		</ul>

	</div>

@stop