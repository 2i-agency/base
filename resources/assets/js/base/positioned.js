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