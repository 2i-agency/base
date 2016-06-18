/*
 * Приведение иконки активатора сворачивания/разворачивания в актуальное состояние
 */
function actualize_collapse_indicator($toggler) {
	$toggler = $($toggler);
	var $icon = $toggler.find('.fa-chevron-down'),
		$target = $($toggler.data('target') || $toggler.attr('href'));

	// Цель скрыта, указатель повёрнут вправо
	if ($target.hasClass('collapse') && $target.hasClass('in'))
	{
		$icon.addClass('fa-rotate-270');
	}
	// Цель показана, указатель повёрнут вниз
	else
	{
		$icon.removeClass('fa-rotate-270');
	}
}