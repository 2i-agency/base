@extends('chunker.base::admin.template')


@section('page.title', 'Добавление пользователя')


@section('page.content')

	{{--Хлебные крошки--}}
	@include('chunker.base::admin.users._breadcrumbs')

	{{--Форма с данными пользователя--}}
	<form method="POST" action="{{ route('admin.users.store') }}" class="panel panel-default">
		@include('chunker.base::admin.users._form')
		<div class="panel-footer">
			@include('chunker.base::admin.utils.buttons.add')
		</div>
	</form>

@stop