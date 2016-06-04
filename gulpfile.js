var elixir = require('laravel-elixir');


elixir(function(mix) {

	mix

		// Базовые стили
		.sass('base.scss', './public/admin/css/base.css')

		// Стили страницы аутентификации
		.sass('auth.scss', './public/admin/css/auth.css')

		// Базовое поведение
		.scripts('base/*.js', './public/admin/js/base.js')

		// Поведение раздела с языками
		.scripts('languages.js', './public/admin/js/languages.js');

});