<!doctype html>
<html lang="ru">
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	{{--jQuery--}}
	<script src="https://yastatic.net/jquery/2.2.0/jquery.min.js"></script>
	<script src="https://yastatic.net/jquery-ui/1.11.2/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="https://yastatic.net/jquery-ui/1.11.2/themes/smoothness/jquery-ui.min.css">

	{{--Bootstrap--}}
	<script src="https://yastatic.net/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://yastatic.net/bootstrap/3.3.4/css/bootstrap.min.css">

	{{--Собственные оформление и поведение страницы--}}
	<link rel="stylesheet" href="{{ asset('admin/css/general.css') }}">
	@yield('page.assets')

	{{--Иконка--}}
	<link rel="shortcut icon" href="{{ asset('admin/img/favicon.png') }}">

	<title>@yield('page.title', 'Админцентр')</title>

</head>
<body>@yield('page.body')</body>
</html>