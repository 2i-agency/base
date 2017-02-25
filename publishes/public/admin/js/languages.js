$(function(){

	/*
	 * Наполнение модального окна при открытии
	 */
	$('#modal-edit').on('show.bs.modal', function(e){
		var $button = $(e.relatedTarget);
		var $modal = $(this);

		// Данные
		var action_update = $button.data('action_update'),
			name = $button.data('name'),
			locale = $button.data('locale'),
			flag = $button.data('flag'),
			flag_image = $('.js-flag-modal'),
			is_published = Number($button.data('is_published'));

		// Настройка окна
		$modal.attr('action', action_update);
		$modal.find('input[name="name"]').val(name);
		$modal.find('input[name="locale"]').val(locale);
		$modal.find('input[name="is_published"][value="' + is_published + '"]').attr('checked', '');
		// Настройки отображения флага
		if (flag.length) {
			flag_image.attr('src', flag);
			flag_image.removeClass('hidden');
		} else {
			flag_image.addClass('hidden');
		}
	})

});