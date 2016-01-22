@inject('navigation', 'Chunker\Base\Helpers\AdminNavigation')
@extends('Base::base')


@section('page.body')

{{--Header with navigation--}}
<header class="navbar navbar-default navbar-fixed-top"><div class="container-fluid">

	{{--Logo--}}
	<div class="navbar-header">

		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapsable">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>

		<a class="navbar-brand" href="{{ $navigation->home() }}">Админцентр</a>

	</div>


	{{--Collapsable content--}}
	<div class="collapse navbar-collapse" id="collapsable">

		{{--Navigation--}}
		{!! $navigation->render() !!}

		{{--User's form--}}
		<form class="navbar-form navbar-right" method="POST" action="{{ route('logout') }}">
			{!! csrf_field() !!}
			<div class="btn-group">
				<a href="{{ route('admin.users.edit', Auth::user()) }}" class="btn btn-default">
					<span class="glyphicon glyphicon-user"></span>
					{{ Auth::user()->getName() }}
				</a>
				<button type="submit" class="btn btn-default" title="Выход">
					<span class="glyphicon glyphicon-log-out"></span>
				</button>
			</div>
		</form>

		{{--Additional links--}}
		<ul class="nav navbar-nav navbar-right">
			<li>
				<a href="{{ url('/') }}" target="_blank">
					<span class="glyphicon glyphicon-new-window"></span>
					Сайт
				</a>
			</li>
			<li>
				<a href="https://metrika.yandex.ru" target="_blank">
					<span class="glyphicon glyphicon-stats"></span>
					Метрика
				</a>
			</li>
		</ul>

	</div>

</div></header>


{{--Page content--}}
<div class="container-fluid">@yield('page.content')</div>

@stop