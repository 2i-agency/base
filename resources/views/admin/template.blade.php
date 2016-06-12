@extends('chunker.base::admin.base')


@section('page.body')

	{{--Шапка с навигацией--}}
	<header class="navbar navbar-default"><div class="container-fluid">

		<div class="navbar-header">

			{{--Иконка меню в мобильной версии--}}
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapsable">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			{{--Логотип--}}
			<a
				class="navbar-brand{{ Route::currentRouteNamed('admin.dashboard') ? ' active' : NULL }}"
				href="{{ route('admin.dashboard') }}"
				data-hover="tooltip"
				data-placement="bottom"
				data-container="body"
				title="Контрольная панель"
			>
				<span class="fa fa-dashboard"></span>
				<span class="hidden-lg hidden-md hidden-sm">Контрольная панель</span>
			</a>

		</div>


		{{--Содержимое, скрываемое в мобильной версии--}}
		<div class="collapse navbar-collapse" id="collapsable">

			{{--Меню админцентра--}}
			@include('chunker.base::admin.utils.nav.menu')


			{{--Форма пользователя--}}
			<form class="navbar-form navbar-right" method="POST" action="{{ route('logout') }}">
				{!! csrf_field() !!}
				<div class="btn-group">

					{{--Ссылка на страницу профиля авторизованного пользователя--}}
					<a
						href="{{ route('admin.users.edit', Auth::user()) }}"
						class="btn btn-default"
						data-hover="tooltip"
						data-placement="bottom"
						data-container="body"
						title="Текущая учётная запись"
					>
						<span class="fa fa-user"></span>
						{{ Auth::user()->getName() }}
					</a>

					{{--Кнопка деавторизации--}}
					<button
						type="submit"
						class="btn btn-default"
						data-hover="tooltip"
						data-placement="bottom"
						data-container="body"
						title="Выход"
					>
						<span class="fa fa-sign-out"></span>
					</button>

				</div>
			</form>


			{{--Языковое меню--}}
			@if (config('chunker.localization.multi'))
				<div class="navbar-form navbar-right dropdown">

					{{--Кнопка с текущим языком--}}
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						{{ $_languages->where('route_key', Session::get('admin.locale'))->first()->name }}
						<span class="caret"></span>
					</button>

					<ul class="dropdown-menu">

						{{--Ссылки на переключение языка--}}
						@if ($_languages->count() > 1)
							@foreach ($_languages->reject(function($language){
								return $language->route_key == Session::get('admin.locale');
							}) as $_language)
								<li>
									<a href="{{ route('admin.set-locale', $_language) }}">
										{{ $_language->name }}
									</a>
								</li>
							@endforeach
							<li class="divider"></li>
						@endif

						{{--Ссыла на раздел редактирования языков--}}
						<li{!! (Route::currentRouteName() == 'admin.languages' ? ' class="active"' : NULL) !!} >
							<a href="{{ route('admin.languages') }}">
								<span class="fa fa-globe"></span>
								Языки
							</a>
						</li>

						{{--Ссылка на раздел перевода интерфейса--}}
						<li{!! (Route::currentRouteName() == 'admin.translation' ? ' class="active"' : NULL) !!}>
							<a href="{{ route('admin.translation') }}">
								<span class="fa fa-language"></span>
								Перевод интерфейса
							</a>
						</li>

					</ul>
				</div>
			@endif


			{{--Вспомогательные ссылки--}}
			<ul class="nav navbar-nav navbar-right">

				{{--Главная страница сайта--}}
				<li>
					<a href="{{ asset('') }}" target="_blank">
						<span class="fa fa-book"></span>
						Сайт
					</a>
				</li>

				{{--Ссылка на метрику--}}
				@if (env('STATISTICS_URL'))
					<li>
						<a href="{{ env('STATISTICS_URL') }}" target="_blank">
							<span class="glyphicon glyphicon-stats"></span>
							Статистика
						</a>
					</li>
				@endif

			</ul>

		</div>

	</div></header>


	{{--Содержимое страницы--}}
	<div class="container-fluid">
		@include('chunker.base::admin.utils.flash.message')
		@yield('page.content')
	</div>

@stop