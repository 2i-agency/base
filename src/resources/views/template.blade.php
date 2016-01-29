@inject('navigation', 'Chunker\Base\Helpers\AdminNavigation')
@extends('Base::base')


@section('page.body')

	{{--Шапка с навигацией--}}
	<header class="navbar navbar-default navbar-fixed-top"><div class="container-fluid">

		<div class="navbar-header">

			{{--Иконка меню--}}
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapsable">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			{{--Логотип--}}
			<a class="navbar-brand" href="{{ $navigation->home() }}">Админцентр</a>

		</div>


		{{--Содержимое, скрываемое в мобильной версии--}}
		<div class="collapse navbar-collapse" id="collapsable">

			{{--Навигация админцентра--}}
			{!! $navigation->render() !!}

			{{--Форма пользователя--}}
			<form class="navbar-form navbar-right" method="POST" action="{{ route('logout') }}">
				{!! csrf_field() !!}
				<div class="btn-group">

					{{--Ссылка на страницу редактирования авторизованного пользователя--}}
					<a href="{{ route('admin.users.edit', Auth::user()) }}" class="btn btn-default">
						<span class="glyphicon glyphicon-user"></span>
						{{ Auth::user()->getName() }}
					</a>

					{{--Кнопка деавторизации--}}
					<button type="submit" class="btn btn-default" title="Выход">
						<span class="glyphicon glyphicon-log-out"></span>
					</button>

				</div>
			</form>

			{{--Вспомогательные ссылки--}}
			<ul class="nav navbar-nav navbar-right">

				{{--Главная страница сайта--}}
				<li>
					<a href="{{ url('/') }}" target="_blank">
						<span class="glyphicon glyphicon-new-window"></span>
						Сайт
					</a>
				</li>

				{{--Статистика посещений--}}
				<li>
					<a href="https://metrika.yandex.ru" target="_blank">
						<span class="glyphicon glyphicon-stats"></span>
						Метрика
					</a>
				</li>

			</ul>

		</div>

	</div></header>


	{{--Содержимое страницы--}}
	<div class="container-fluid">@yield('page.content')</div>

@stop