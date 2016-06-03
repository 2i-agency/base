@extends('chunker.base::template')


@section('page.title', 'Добавление пользователя')


@section('page.content')

	<h3>Добавление пользователя</h3>

	{{--Хлебные крошки--}}
	@include('chunker.base::users._utils.breadcrumbs')

	{{--Форма с данными пользователя--}}
	<form method="POST" action="{{ route('admin.users.store') }}" class="panel panel-default">
		@include('chunker.base::users._utils.user-form')
	</form>

@stop