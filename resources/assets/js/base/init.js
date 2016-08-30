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


	// Плизиционируемые элементы
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


	// Календари
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

});