@extends('chunker.base::admin.auth.template')


@section('page.title', 'Аутентификация')


@section('content')

	{{--Форма атворизации--}}
	<form method="POST" class="panel panel-default" action="{{ route('login') }}">
		{!! csrf_field() !!}

		<div class="panel-heading">
			<h4 class="panel-title">
				<span class="fa fa-lock"></span>
				Вход в админцентр
			</h4>
		</div>

		<div class="panel-body">

			@include('chunker.base::admin.utils.errors')

			{{--Логин--}}
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

			{{--Пароль--}}
			<div class="form-group">
				<input
					type="password"
					name="password"
					required
					class="form-control"
					placeholder="Пароль">
			</div>

			{{--Запоминание--}}
			<div class="form-group">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="remember" value="1">Запомнить меня
					</label>
				</div>
			</div>

		</div>

		<div class="panel-footer">

			<div class="row">

				{{--Кнопка авторизации--}}
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<button type="submit" class="btn btn-primary">
						<span class="fa fa-sign-in"></span>
						Войти
					</button>
				</div>

				{{--Ссылка на страницу восстановления пароля--}}
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
					<p class="form-control-static text-right">
						<a href="#">Восстановление доступа</a>
					</p>
				</div>

			</div>

		</div>

	</form>

@stop