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
		})

});