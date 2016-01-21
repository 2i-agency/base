@extends('Base::template')


@section('page.content')

	<h3>Данные пользователя «{{ $user->getName() }}»</h3>

	@include('Base::users._utils.breadcrumbs')

	<ul class="nav nav-tabs">
		<li class="active"><a href="{{ route('admin.users.edit', $user) }}">Данные</a></li>
		<li><a href="{{ route('admin.users.authorizations', $user) }}">Авторизации</a></li>
	</ul>

	<form method="POST" action="{{ route('admin.users.update', $user) }}" class="panel panel-default">
		{!! method_field('PUT') !!}
		@include('Base::users._utils.user-form')
	</form>

@stop