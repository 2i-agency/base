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
				class="navbar-brand{{ Route::currentRouteNamed('admin.notices') ? ' active' : NULL }}"
				href="{{ route('admin.notices') }}"
				data-hover="tooltip"
				data-placement="bottom"
				data-container="body"
				title="Уведомления"
			>
				<span class="fa fa-envelope"></span>
				<span class="hidden-lg hidden-md hidden-sm">Уведомления</span>
			</a>

		</div>


		{{--Содержимое, скрываемое в мобильной версии--}}
		<div class="collapse navbar-collapse" id="collapsable">

			{{--Меню админцентра--}}
			@include('chunker.base::admin.utils.nav.menu')

			{{--Форма пользователя--}}
			<form class="navbar-form navbar-right" method="POST" action="{{ route('admin.logout') }}">
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
			@if (config('chunker.localization.multi') && (Auth::user()->can('languages.view') || Auth::user()->can('translation.view') || $_languages->count() > 1))
				<div class="navbar-form navbar-right dropdown">

					{{--Кнопка с текущим языком--}}
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						{{ $_languages->where('locale', Session::get('admin.locale'))->first()->name }}
						<span class="caret"></span>
					</button>

					<ul class="dropdown-menu">

						{{--Ссылки на переключение языка--}}
						@if ($_languages->count() > 1)
							@foreach ($_languages->reject(function($language){
								return $language->locale == Session::get('admin.locale');
							}) as $_language)
								<li>
									<a href="{{ route('admin.set-locale', $_language) }}">
										{{ $_language->name }}
									</a>
								</li>
							@endforeach
						@endif

						@if(Auth::user()->can('languages.view') || Auth::user()->can('translation.view'))

							<li class="divider"></li>

							{{--Ссылка на раздел редактирования языков--}}
							@can('languages.view')
								<li{!! (Route::currentRouteName() == 'admin.languages' ? ' class="active"' : NULL) !!} >
									<a href="{{ route('admin.languages') }}">
										<span class="fa fa-globe"></span>
										Языки
									</a>
								</li>
							@endcan

							{{--Ссылка на раздел перевода интерфейса--}}
							@can('translation.view')
								<li{!! (Route::currentRouteName() == 'admin.translation' ? ' class="active"' : NULL) !!}>
									<a href="{{ route('admin.translation') }}">
										<span class="fa fa-language"></span>
										Перевод интерфейса
									</a>
								</li>
							@endcan

						@endif

					</ul>
				</div>
			@endif


			{{--Дополнительные ссылки--}}
			<ul class="nav navbar-nav navbar-right">

				@foreach(config('chunker.admin.links') as $link)
					<li>
						<a href="{!! $link['url'] !!}" target="_blank">
							@if (isset($link['icon']))
								<span class="fa fa-{{ $link['icon'] }}"></span>
							@endif
							{{ $link['name'] }}
						</a>
					</li>
				@endforeach

			</ul>

		</div>

	</div></header>


	{{--Содержимое страницы--}}
	<div class="container-fluid">
		@include('chunker.base::admin.utils.flash.message')
		@yield('page.content')
	</div>

@stop