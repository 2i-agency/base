@extends('chunker.base::auth.template')


@section('page.title', 'Аутентификация')


@section('content')

	{{--Форма аутентификации--}}
	<form method="POST" class="panel panel-default" action="{{ route('admin.login') }}">
		{!! csrf_field() !!}

		<div class="panel-heading">
			<h4 class="panel-title">
				<span class="fa fa-lock"></span>
				Вход в админцентр
			</h4>
		</div>

		<div class="panel-body">

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

				{{--Кнопка аутентификации--}}
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<button type="submit" class="btn btn-primary">
						<span class="fa fa-sign-in"></span>
						Войти
					</button>
				</div>

				{{--Ссылка на страницу сброса пароля--}}
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
					<p class="form-control-static text-right">
						<a href="{{ route('admin.reset-password-form') }}">Восстановление доступа</a>
					</p>
				</div>

			</div>

		</div>

	</form>

@stop