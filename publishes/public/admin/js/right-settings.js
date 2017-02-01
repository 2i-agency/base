$(function () {
	var $button = $('#js-right-button'),
		$container = $('#js-right-container'),
		$body = $container.find('.js-body');

	function initForm() {
		$('#js-error-right').addClass('hidden');
		$('[data-hover="tooltip"]').tooltip();
		$('[data-toggle="popover"]').popover({
			html: true,
			trigger: 'hover'
		});

		$('#js-btn-add-right').click(function () {

			$.ajax({
				url: $('#js-add-right').data('url'),
				type: 'post',
				data: {
					'agent': $('#js-new-agent').val(),
					'ability_agent': $('#js-new-ability').val(),
					'ability': $button.data('ability'),
					'id': $button.data('id'),
					'model': $button.data('model')
				},

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
		});

		$('.js-btn-update-right').click(function () {

			$.ajax({
				url: $(this).data('url'),
				type: 'post',
				data: {
					'agent': $(this).data('agent'),
					'ability_agent': $('#js-update-agent-' + $(this).data('agent')).val(),
					'ability': $button.data('ability'),
					'id': $button.data('id'),
					'model': $button.data('model')
				},

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

		});

		$('.js-btn-delete-right').click(function () {

			$.ajax({
				url: $(this).data('url'),
				type: 'post',
				data: {
					'agent': $(this).data('agent'),
					'ability_agent': $('#js-update-agent-' + $(this).data('agent')).val(),
					'ability': $button.data('ability'),
					'id': $button.data('id'),
					'model': $button.data('model')
				},

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

		});

	}

	$button.magnificPopup({
		items: {
			type:'inline',
			src: $container
		},
		removalDelay: 300,
		mainClass: 'mfp-fade',

		callbacks: {
			beforeOpen: function() {
				$('#js-error-right').addClass('hidden');

				$.ajax({
					url: $button.data('url'),
					type: 'post',
					data: {
						'id': $button.data('id'),
						'ability': $button.data('ability'),
						'model': $button.data('model')
					},

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
			},
			afterClose: function () {
				$body.html('');
			}
		}
	});
});