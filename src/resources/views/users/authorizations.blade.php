@extends('Base::template')


@section('page.content')

	<h3>Авторизации пользователя «{{ $user->getName() }}»</h3>

	@include('Base::users._utils.breadcrumbs')

	<ul class="nav nav-tabs">
		<li><a href="{{ route('admin.users.edit', $user) }}">Данные</a></li>
		<li class="active"><a href="{{ route('admin.users.authorizations', $user) }}">Авторизации</a></li>
	</ul>

@stop