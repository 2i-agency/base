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

	// Всплывающие подсказки
	$('[data-hover="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover({
		html: true,
		trigger: 'hover'
	});

});
$(function(){

	$('.positioned').sortable({
		update: function(e, ui) {
			var $wrapper = $(ui.item[0]).closest('.positioned'),
				ids = $wrapper.sortable('toArray', {attribute: 'data-id'});

			$.ajax({
				url: $wrapper.data('url'),
				data: {
					ids: JSON.stringify(ids)
				}
			});

		}
	});

});