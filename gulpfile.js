var elixir = require('laravel-elixir');


elixir(function(mix) {

	mix

		// Базовые стили
		.sass([
			'./node_modules/codemirror/lib/codemirror.css',
			'./node_modules/codemirror/theme/monokai.css',
			'./node_modules/codemirror/addon/dialog/dialog.css',
			'./node_modules/codemirror/addon/display/fullscreen.css',
			'./node_modules/codemirror/addon/hint/show-hint.css',
			'base.scss'
		], './publishes/public/admin/css/base.css')

		// Шрифты Bootstrap
		.copy('./node_modules/bootstrap-sass/assets/fonts', './publishes/public/admin/fonts')

		// Стили страницы аутентификации
		.sass('auth.scss', './publishes/public/admin/css/auth.css')

		// Базовое поведение
		.scripts([

			'./node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',

			'./node_modules/moment/moment.js',
			'./node_modules/moment/locale/ru.js',

			'./node_modules/eonasdan-bootstrap-datetimepicker-npm/src/js/bootstrap-datetimepicker.js',

			'./node_modules/codemirror/lib/codemirror.js',
			'./node_modules/codemirror/mode/xml/xml.js',
			'./node_modules/codemirror/mode/javascript/javascript.js',
			'./node_modules/codemirror/mode/css/css.js',
			'./node_modules/codemirror/mode/htmlmixed/htmlmixed.js',
			'./node_modules/codemirror/addon/dialog/dialog.js',
			'./node_modules/codemirror/addon/edit/matchbrackets.js',
			'./node_modules/codemirror/addon/edit/closebrackets.js',
			'./node_modules/codemirror/addon/edit/matchtags.js',
			'./node_modules/codemirror/addon/edit/closetag.js',
			'./node_modules/codemirror/addon/fold/xml-fold.js',
			'./node_modules/codemirror/addon/hint/show-hint.js',
			'./node_modules/codemirror/addon/hint/xml-hint.js',
			'./node_modules/codemirror/addon/hint/html-hint.js',
			'./node_modules/codemirror/addon/hint/css-hint.js',
			'./node_modules/codemirror/addon/search/searchcursor.js',
			'./node_modules/codemirror/addon/search/search.js',
			'./node_modules/codemirror/addon/search/jump-to-line.js',
			'./node_modules/codemirror/addon/display/fullscreen.js',

			'base/actualize-collapse-indicator.js',
			'base/get-tinymce-config.js',
			'base/init-positionable.js',
			'base/init.js',
			'base/right-settings.js'

		], './publishes/public/admin/js/base.js')

		// Поведение раздела с языками
		.scripts('languages.js', './publishes/public/admin/js/languages.js');

});