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

		image_dimensions: false,

		menubar: false,

		plugins: [
			"charmap code fullscreen image link media",
			"nonbreaking paste searchreplace table lists textcolor"
		],
		toolbar: "fullscreen undo redo | copy paste | removeformat | bold italic strikethrough | sup sub | alignleft aligncenter alignright | forecolor backcolor | formatselect fontsizeselect | bullist numlist outdent indent | table | link unlink | image media | charmap nonbreaking | searchreplace code",
		fontsize_formats: '10px 12px 14px 18px 24px 36px'
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
}