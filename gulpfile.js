var elixir = require('laravel-elixir');


elixir(function(mix) {

	mix

		// Базовые стили
		.sass('base.scss', './public/admin/css/base.css')

		// Шрифты Bootstrap
		.copy('./node_modules/bootstrap-sass/assets/fonts', './public/admin/fonts')

		// Стили страницы аутентификации
		.sass('auth.scss', './public/admin/css/auth.css')

		// Базовое поведение
		.scripts([
			'./node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
			'./node_modules/moment/moment.js',
			'./node_modules/moment/locale/ru.js',
			'./node_modules/eonasdan-bootstrap-datetimepicker-npm/src/js/bootstrap-datetimepicker.js',
			'base/actualize-collapse-indicator.js',
			'base/get-tinymce-config.js',
			'base/init.js'
		], './public/admin/js/base.js')

		// Поведение раздела с языками
		.scripts('languages.js', './public/admin/js/languages.js');

});