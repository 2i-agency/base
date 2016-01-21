@extends('Base::template')


@section('page.content')

	<h3>Добавление пользователя</h3>

	@include('Base::users._utils.breadcrumbs')

	<form method="POST" action="{{ route('admin.users.store') }}" class="panel panel-default">
		@include('Base::users._utils.user-form')
	</form>

@stop