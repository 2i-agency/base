/*
 * Формирование конфига редактора TInyMCE
 */
function get_tinymce_config(data){

	// Конфигурация по умолчанию
	var config = {
		selector: ".tinymce",
		language: 'ru',
		content_css: '/css/tinymce.css',
		height: 400,
		extended_valid_elements: 'script[language|type|src]',

		block_formats: 'Параграф=p;Заголовок 1=h1;Заголовок 2=h2;Заголовок 3=h3',

		link_assume_external_targets: true,
		link_title: false,
		convert_urls: false,

		menubar: false,

		plugins: [
			"charmap code fullscreen image link media",
			"nonbreaking paste searchreplace table"
		],
		toolbar: "fullscreen undo redo | copy paste | removeformat | bold italic strikethrough | sup sub | alignleft aligncenter alignright | formatselect | bullist numlist outdent indent | table | link unlink | image media | charmap nonbreaking | searchreplace code"
	};


	// Частные параметры
	if (data)
	{
		for (var param in data)
		{
			config[param] = data[param];
		}
	}


	return config;
};
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