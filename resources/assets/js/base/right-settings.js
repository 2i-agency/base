$(function () {
	var $button = $('#js-right-button'),
		$container = $('#js-right-container'),
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
		$('#js-error-right').addClass('hidden');
		sent_data(
			$button.data('url'),
			{
				'id': $button.data('id'),
				'ability': $button.data('ability'),
				'model': $button.data('model')
			}
		);
	});

	$container.on('hidden.bs.modal', function () {
		$body.html('');
	});
});