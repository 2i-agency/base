$(function(){

	$('.positioned').sortable({
		update: function(e, ui){
			// DOM elements
			var $elem = $(ui.item[0]);
			var $wrapper = $elem.closest('.positioned');

			// Data
			var id = $elem.data('id');
			var ids = $wrapper.sortable('toArray', {attribute: 'data-id'});

			// Finding position
			for (var i = 0; i < ids.length; i++)
			{
				if (id == ids[i])
				{
					var position = i + 1;
					break;
				}
			}

			// Sending request
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