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
			is_published = Number($button.data('is_published'));

		// Настройка окна
		if (flag.length) {
			$('.js-flag-modal img').attr('src', flag);
			$('.js-flag-modal').removeClass('hidden');
		} else {
			$('.js-flag-modal').addClass('hidden');
		}
		$modal.attr('action', action_update);
		$modal.find('input[name="name"]').val(name);
		$modal.find('input[name="locale"]').val(locale);
		$modal.find('input[name="is_published"][value="' + is_published + '"]').attr('checked', '');
	})

});