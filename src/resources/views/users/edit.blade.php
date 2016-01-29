@extends('Base::template')


@section('page.title', 'Пользователь «' . $user->getName() . '»')


@section('page.content')

	<h3>Пользователь «{{ $user->getName() }}»</h3>

	{{--Хлебные крошки--}}
	@include('Base::users._utils.breadcrumbs')

	{{--Табы--}}
	<ul class="nav nav-tabs">
		<li class="active"><a href="{{ route('admin.users.edit', $user) }}">Данные</a></li>
		<li><a href="{{ route('admin.users.authorizations', $user) }}">Авторизации</a></li>
	</ul>

	{{--Форма с данными пользователя--}}
	<form method="POST" action="{{ route('admin.users.update', $user) }}" class="panel panel-default">
		{!! method_field('PUT') !!}
		@include('Base::users._utils.user-form')
	</form>

@stop