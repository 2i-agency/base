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
			var $wrapper = $(ui.item[0]).closest('.js-positionable'),
				ids = $wrapper.sortable('toArray', {attribute: 'data-id'});

			$.ajax({
				url: $wrapper.data('url'),
				data: {
					ids: JSON.stringify(ids)
				}
			});

		}
	});


	// Календари
	$('.js-datetimepicker').datetimepicker({ locale: 'ru' });

});