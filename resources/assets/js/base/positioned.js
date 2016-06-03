$(function(){

	$('.positioned').sortable({
		update: function(e, ui) {

			// Ссылки на элементы страницы
			var $elem = $(ui.item[0]);
			var $wrapper = $elem.closest('.positioned');

			// Ключи активного элемента и всех элементов
			var id = $elem.data('id');
			var ids = $wrapper.sortable('toArray', {attribute: 'data-id'});

			// Определение новой позиции элемента
			for (var i = 0; i < ids.length; i++) {
				if (id == ids[i]) {
					var position = i + 1;
					break;
				}
			}

			// Отправка запроса на сервер для сохранения новой позиции
			$.ajax({
				url: $wrapper.data('url'),
				data: {
					id: id,
					position: position
				}
			});

		}
	});

});