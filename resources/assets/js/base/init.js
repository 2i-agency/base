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
	$('.js-positionable').sortable({
		update: function(e, ui) {
			var $item = $(ui.item[0]),
				$wrapper = $item.closest('.js-positionable');

			$.ajax({
				url: $wrapper.data('url'),
				data: {
					moved:	$item.data('id'),
					prev:	$item.prev().data('id'),
					next:	$item.next().data('id')
				}
			});
		}
	});


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
		// Текстовое поле
		var $textarea = $(textarea),
			css = $textarea.data('css');

		if (css) {
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
			autoCloseTags: true,
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


		// Айфрейм
		var $iframe = $('<iframe frameborder="no">')
			.appendTo($preview)
			.css('width', '100%')
			.attr('srcdoc', '<!doctype html><html><head><link rel="stylesheet" href="' + css + '"></head><body></body></html>');


		// Перерасчет высоты айфрейма с учетом высоты горизонтальной полосы прокрутки
		setInterval(function() {
			var $body = $($iframe.contents().find('body')),
				height = $body.outerHeight() + 40;
			$iframe.height(height);
		}, 100);


		// Предпросмотр
		$tabs
			.find('a[href="#preview' + num + '"]')
			.on('shown.bs.tab', function(e) {
				update_iframe_body($iframe, cm);
			});
	});
	
	
	/*
	 * Обновление содержимое айфрейма
	 */
	function update_iframe_body($iframe, codeMirror) {
		$iframe
			.contents()
			.find('body')
			.html(codeMirror.getValue());
	}

});