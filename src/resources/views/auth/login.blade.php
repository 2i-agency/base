@extends('Admin::auth.template')


@section('page.title', 'Авторизация')


@section('content')

<form method="POST" class="panel panel-default" action="{{ route('login') }}">
	{!! csrf_field() !!}

	<div class="panel-heading">
		<h4 class="panel-title">
			<span class="glyphicon glyphicon-lock"></span>
			Авторизация
		</h4>
	</div>

	<div class="panel-body">

		<div class="form-group">
			<input
				type="text"
				name="login"
				value="{{ old('login') }}"
				required
				autofocus
				class="form-control"
				autocomplete="off"
				placeholder="Логин">
		</div>

		<div class="form-group">
			<input
				type="password"
				name="password"
				required
				class="form-control"
				placeholder="Пароль">
		</div>

		<button type="submit" class="btn btn-success">
			<span class="glyphicon glyphicon-log-in"></span>
			Войти
		</button>

	</div>

</form>

@stop