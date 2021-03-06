$(function()
{
	var queue = QueueFactory();

	if ($('#sidebar').attr('data-can-edit') == '1')
	{
		$('#sidebar a.list').each(function(i, listItem)
		{
			var dragger = $('<a>');
			dragger.attr('href', '#');
			dragger.addClass('dragger');
			dragger.append('<i class="icon icon-drag">');
			dragger.insertBefore(listItem);

			initMoveDragger(
				dragger,
				'li',

				function(target)
				{
				},

				function(target, isChanged)
				{
					if (!isChanged)
						return;
					var userName = target.attr('data-user-name');
					var listId = target.attr('data-list-id');
					var priority = target.index() + 1;
					queue.push(new Job('set-list-position', {
						'user-name': userName,
						'list-id': listId,
						'new-position': priority}));
					queue.delayedFlush();
				});

		});
	}
});
