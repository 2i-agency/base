$(function(){

	// Всплывающие подсказки
	$('[data-hover="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover({
		html: true,
		trigger: 'hover'
	});


	// Поворот иконки у инициализатора сворачивания/разворачивания во время срабатывания
	$('[data-toggle="collapse"]')
		.each(function(){
			var $toggler = $(this);

			$($toggler.data('target') || $toggler.attr('href'))
				.on('hide.bs.collapse show.bs.collapse', function(){
					actualize_collapse_indicator($toggler);
				});
		});


	// Позиционируемые элементы
	init_positionable('.js-positionable');


	// Календарь
	$('.js-timepicker').each(function(num, elem) {
		var $picker = $(elem),
			format = $picker.data('format') || 'DD.MM.YYYY HH:mm';

		$(elem).datetimepicker({
			locale: 'ru',
			format: format,
			showTodayButton: true,
			showClear: true,
			tooltips: {
				today: 'Выбрать сегодня',
				clear: 'Очистить'
			}
		});
	});


	/*
	 * Редактор кода
	 */
	$('textarea.js-editor').each(function(num, textarea){
		var $textarea = $(textarea),
			css = $textarea.data('css'),
			js = $textarea.data('js'),
			is_need_preview = Boolean(css || js);

		if (is_need_preview) {
			var need_update_height = true;

			// Табы
			var $tabs = $('<ul class="nav nav-tabs"></ul>')
				.append('<li class="active"><a href="#editor' + num + '"><span class="fa fa-code"/> Редактор</a></li>')
				.append('<li><a href="#preview' + num + '"><span class="fa fa-eye"/> Просмотр</a></li>');

			// Содержимое табов
			var $tabs_content = $('<div class="tab-content">'),
				$editor = $('<div class="tab-pane active" id="editor' + num + '">'),
				$preview = $('<div class="tab-pane" id="preview' + num + '">');

			$tabs_content
				.append($editor)
				.append($preview);

			// Инициализация табов
			$tabs.find('a').click(function(e) {
				e.preventDefault();
				$(this).tab('show');
			});

			// Расстановка
			$textarea.after($tabs);
			$tabs.after($tabs_content);
			$editor.append($textarea);
		}


		// Инициализация редактора
		var cm = CodeMirror.fromTextArea(textarea, {
			mode: 'text/html',
			theme: 'monokai',
			autoCloseBrackets: true,
			matchBrackets: true,
			matchTags: true,
			lineNumbers: true,
			tabSize: 2,
			indentWithTabs: true,
			lineWrapping: true,
			readOnly: textarea.disabled,

			extraKeys: {
				"F11": function(cm) {
					cm.setOption("fullScreen", !cm.getOption("fullScreen"));
				},
				"Esc": function(cm) {
					if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
				},
				"Ctrl-Space": "autocomplete"
			}
		});


		if (is_need_preview) {
			var stylesheets = '',
				scripts = '';

			// Подготовка CSS
			for (var i in css) {
				stylesheets += '<link rel="stylesheet" href="' + css[i] + '">';
			}

			// Подготовка js
			for (var i in js) {
				scripts += '<script src="' + js[i] + '"></script>';
			}


			// Айфрейм
			var $iframe = $('<iframe frameborder="no">')
				.appendTo($preview)
				.css('width', '100%')
				.attr('srcdoc', '<!doctype html><html><head>' + stylesheets + scripts + '</head><body></body></html>');


			// Предпросмотр
			$tabs
				.find('a[href="#preview' + num + '"]')
				.on('shown.bs.tab', function(e) {
					var $body = $($iframe.contents().find('body'));

					$body.html(cm.getValue());

					if (need_update_height) {
						$iframe.height($body.outerHeight() + 40);
						need_update_height = false;
					}
				});


			// Смена флага необходимости изменения высота айфрейма
			cm.on('change', function() {
				need_update_height = true;
			})
		}
	});

});