$(function () {
	var	$container = $('#js-right-container'),
		$body = $container.find('#js-right-body');

	initRightButton();

	$container.on('show.bs.modal', function () {
		initRightForm();
	});

	$container.on('hidden.bs.modal', function () {
		$body.html('');
	});
});


// Отправка запроса и получение ответа
function sentRightData(url, data) {
	var $container = $('#js-right-container'),
		$body = $container.find('#js-right-body');

	$.ajax({
		url: url,
		type: 'post',
		data: data,

		success: function (data) {
			if (data != "") {
				$body.html(data);

				initRightForm();
			}

		},

		statusCode:{
			403: function(){
				$('#js-error-right').text('Вы не можете редактировать права').removeClass('hidden');
			}
		}
	});
}

// Инициализация кнопок Настройки прав
function initRightButton() {
	$('.js-right-button').click(function () {
		$button = $(this);
		$('#js-error-right').addClass('hidden');
		sentRightData(
			$(this).data('url'),
			{
				'id': $(this).data('id'),
				'ability': $(this).data('ability'),
				'model': $(this).data('model')
			}
		);
	});
}

// Инициализация формы
function initRightForm() {
	// Скрываем уведомления
	$('#js-error-right').addClass('hidden');
	// Инициализируем подсказки в форме
	$('[data-hover="tooltip"]').tooltip();

	// Добавление
	$('#js-btn-add-right').click(function () {

		sentRightData(
			$('#js-add-right').data('url'),
			{
				'agent': $('#js-new-agent').val(),
				'ability_agent': $('#js-new-ability').val(),
				'ability': $button.data('ability'),
				'id': $button.data('id'),
				'model': $button.data('model')
			}
		);

	});

	// Сохранение
	$('.js-btn-update-right').click(function () {

		sentRightData(
			$(this).data('url'),
			{
				'agent': $(this).data('agent'),
				'ability_agent': $('#js-update-agent-' + $(this).data('agent')).val(),
				'ability': $button.data('ability'),
				'id': $button.data('id'),
				'model': $button.data('model')
			}
		);

	});

	// Удаление
	$('.js-btn-delete-right').click(function () {

		sentRightData(
			$(this).data('url'),
			{
				'agent': $(this).data('agent'),
				'ability_agent': $('#js-update-agent-' + $(this).data('agent')).val(),
				'ability': $button.data('ability'),
				'id': $button.data('id'),
				'model': $button.data('model')
			}
		);

	});

}