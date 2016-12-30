@extends('base::template')


@section('page.title', 'Добавление пользователя')


@section('page.content')

	{{--Хлебные крошки--}}
	@include('base::users._breadcrumbs')

	{{--Форма с данными пользователя--}}
	<form
		method="POST"
		action="{{ route('admin.users.store') }}"
		class="panel panel-default"
	>
		@include('base::users._form')
		<div class="panel-footer">
			@include('base::utils.buttons.add')
		</div>
	</form>

@stop