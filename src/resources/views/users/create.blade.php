@extends('Base::template')


@section('page.title', 'Добавление пользователя')


@section('page.content')

	<h3>Добавление пользователя</h3>

	{{--Хлебные крошки--}}
	@include('Base::users._utils.breadcrumbs')

	{{--Форма с данными пользователя--}}
	<form method="POST" action="{{ route('admin.users.store') }}" class="panel panel-default">
		@include('Base::users._utils.user-form')
	</form>

@stop