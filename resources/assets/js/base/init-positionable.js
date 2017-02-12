/**
 * Инициализация позиционируемых элементов
 */
function init_positionable(selector) {
	$(selector)
		.sortable({
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
			},
			cancel: '.ui-state-disabled'
		})
		.disableSelection();
}