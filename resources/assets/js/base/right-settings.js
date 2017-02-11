$(function () {
	var	$container = $('#js-right-container'),
		$body = $container.find('#js-right-body');

	// Отправка запроса и получение ответа
	function sent_data(url, data) {
		$.ajax({
			url: url,
			type: 'post',
			data: data,

			success: function (data) {
				if (data != "") {
					$body.html(data);

					initForm();
				}

			},

			statusCode:{
				403: function(){
					$('#js-error-right').text('Вы не можете редактировать права').removeClass('hidden');
				}
			}
		});
	}

	$('.js-right-button').click(function () {
console.log('fdsfsd');
		$('#js-error-right').addClass('hidden');
		sent_data(
			$(this).data('url'),
			{
				'id': $(this).data('id'),
				'ability': $(this).data('ability'),
				'model': $(this).data('model')
			}
		);
	});


	// Инициализация формы
	function initForm() {
		// Скрываем уведомления
		$('#js-error-right').addClass('hidden');
		// Инициализируем подсказки в форме
		$('[data-hover="tooltip"]').tooltip();

		// Добавление
		$('#js-btn-add-right').click(function () {

			sent_data(
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

			sent_data(
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

			sent_data(
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

	$container.on('show.bs.modal', function () {
		initForm();
	});

	$container.on('hidden.bs.modal', function () {
		$body.html('');
	});
});