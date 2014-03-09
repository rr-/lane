$(function()
{
	var queue = new Queue();
	var listId = $('#list').attr('data-list-id');

	$('#add-row').click(function()
	{
		queue.push(new Job('list-add-row', [listId]));
		queue.delayedFlush();
	});

	$('#list-management .add-list, #list-management .settings, #menu .login, #menu .register').click(function(e)
	{
		e.preventDefault();
		showPopup($(this).attr('href'));
	});

	$('#menu .logout').click(function(e)
	{
		e.preventDefault();
		$.post($(this).attr('href'), function()
		{
			window.location.reload();
		});
	});
});
