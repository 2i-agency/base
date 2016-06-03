var elixir = require('laravel-elixir');


elixir(function(mix) {

	mix

		// Базовые стили
		.sass('base.scss', './public/admin/css/base.css')

		// Базовое поведение
		.scripts('base/*.js', './public/admin/js/base.js')

		// Поведение раздела с языками
		.scripts('languages.js', './public/admin/js/languages.js');

});