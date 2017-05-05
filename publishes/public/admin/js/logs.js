$(function () {
	var $accordions = $('.collapse');

	function getId(text){
		return parseInt(text.replace(/\D+/g,""));
	}

	$accordions.on('show.bs.collapse', function () {
		var id = getId($(this).attr('id')),
			$wrapper = $(this).find('.panel-body');

		$.ajax({
			url: $(this).data('url'),
			type: $(this).data('method'),
			data: {
				'log': id
			},
			success: function(data){
				$wrapper.find('.preload').hide();
				$wrapper.find('.content').html(data);
			}
		});
	});

	$accordions.on('hide.bs.collapse', function () {
		$(this).find('.panel-body .content').html('');
	});

	$accordions.on('hidden.bs.collapse', function () {
		$(this).find('.panel-body .preload').show();
	});

});