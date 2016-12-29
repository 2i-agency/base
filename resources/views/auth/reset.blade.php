@extends('chunker.base::auth.template')


@section('page.title', 'Сброс пароля')


@section('content')

	{{--Форма аутентификации--}}
	<form method="POST" class="panel panel-default" action="{{ route('admin.reset-password') }}">
		{!! csrf_field() !!}

		<div class="panel-heading">
			<h4 class="panel-title">
				<span class="fa fa-lock"></span>
				Cброс пароля
			</h4>
		</div>

		<div class="panel-body">

			{{--Логин или электронный адрес--}}
			<div class="form-group">
				<input
					type="text"
					name="login"
					value="{{ old('login') }}"
					required
					autofocus
					class="form-control"
					autocomplete="off"
					placeholder="Логин или электронный адрес">
			</div>

		</div>

		<div class="panel-footer">
			<div class="row">

				{{--Кнопка авторизации--}}
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<button type="submit" class="btn btn-primary">
						<span class="fa fa-gavel"></span>
						Сбросить пароль
					</button>
				</div>

				{{--Ссылка на страницу авторизации--}}
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<p class="form-control-static text-right">
						<a href="{{ route('admin.notices') }}">Аутентификация</a>
					</p>
				</div>

			</div>
		</div>

	</form>

@stop