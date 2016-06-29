<!doctype html>
<html lang="ru">
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>@yield('page.title', 'Админцентр')</title>

	{{--jQuery--}}
	<script src="https://yastatic.net/jquery/2.2.3/jquery.min.js"></script>
	<script src="https://yastatic.net/jquery-ui/1.11.2/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="https://yastatic.net/jquery-ui/1.11.2/themes/smoothness/jquery-ui.min.css">

	{{--Иконки FontAwesome--}}
	<script src="https://use.fontawesome.com/4fa1e38ea7.js"></script>

	{{--Собственные оформление и поведение страницы--}}
	<script src="{{ asset('admin/js/base.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('admin/css/base.css') }}">
	@yield('page.assets')

	{{--Иконка админки--}}
	<link rel="shortcut icon" href="{{ asset('admin/img/favicon.png') }}">

</head>
<body>@yield('page.body')</body>
</html>