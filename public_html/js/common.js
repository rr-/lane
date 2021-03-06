function enableExitConfirmation(message)
{
	if (typeof(message) === 'undefined')
		message = 'There are unsaved changes.';

	$(window).bind('beforeunload', function(e)
	{
		return message;
	});
}

function disableExitConfirmation()
{
	$(window).unbind('beforeunload');
}

function appendUrlParameter(url, key, value)
{
	url = url.replace(new RegExp('[?&]' + key + '(=[^?&]+|(?!>[?&])|$)', 'g'), '');
	var sep = url.indexOf('?') != - 1
		? '&'
		: '?';
	url += sep;
	url += key;
	if (typeof(value) !== 'undefined')
		url += '=' + value;
	return url;
}

function sendAjax(url, data, successFunc, errorFunc)
{
	var ajaxParams =
	{
		type: 'POST',
		url: url,
		data: data,
	};

	if (data instanceof FormData)
	{
		ajaxParams.enctype = 'multipart/form-data';
		ajaxParams.processData = false;
		ajaxParams.contentType = false;
	}

	$.ajax(ajaxParams).done(function(rawContent)
	{
		var content = $(rawContent);
		if (typeof(successFunc) !== 'undefined')
			successFunc(content);
		else
			window.location = content.filter('meta[data-current-url]').attr('data-current-url');
	}).fail(function(xhr)
	{
		var content = $(xhr.responseText);
		if (typeof(errorFunc) !== 'undefined')
			errorFunc(content);
		else
			alert(content.find('.message').text());
	});
}

$(function()
{
	$('body').on('submit', 'form', function(e)
	{
		e.preventDefault();

		var form = $(this);
		var url = appendUrlParameter(form.attr('action'), 'simple');
		var data = (typeof form.data('serializer') !== 'undefined')
			? form.data('serializer')()
			: form.serialize();

		var target = form.closest('.content-wrapper');
		if (target.length == 0)
			target = form;

		var send = function()
		{
			sendAjax(url, data, form.data('success-callback'), form.data('error-callback'));
		}

		var messages = target.find('.message');
		if (messages.length > 0)
			messages.slideUp().fadeOut('fast', send);
		else
			send();
	});
});

function initGenericDragger(dragger, parentElement, dragStartCallback, dragMoveCallback, dragFinishCallback)
{
	$(dragger).mousedown(function(e)
	{
		e.preventDefault();
		var target = $(e.target).parents(parentElement);
		target.addClass('dragging');
		target.data('changed', false);

		var internalDragMoveCallback = function(e)
		{
			dragMoveCallback(target, e);
		};

		$('body')
			.addClass('dragging')
			.on('mousemove', target, internalDragMoveCallback)
			.one('mouseup', function(e)
		{
			e.preventDefault();
			target.removeClass('dragging');
			$('body').removeClass('dragging')
			$('body').off('mousemove', internalDragMoveCallback);
			if (typeof(dragFinishCallback) !== 'undefined')
				dragFinishCallback(target, target.data('changed'));
		});

		if (typeof(dragStartCallback) !== 'undefined')
			dragStartCallback(target);

	}).click(function(e)
	{
		e.preventDefault();
	});
}

function moveDragHandler(target, e)
{
	while (e.pageY < target.offset().top && target.prev().length > 0)
	{
		target.data('changed', true);
		target.insertBefore(target.prev());
	}
	while (e.pageY > target.offset().top + target.height() && target.next().length > 0)
	{
		target.data('changed', true);
		target.insertAfter(target.next());
	}
}

function initMoveDragger(dragger, parentElement, dragStartCallback, dragFinishCallback)
{
	return initGenericDragger(dragger, parentElement, dragStartCallback, moveDragHandler, dragFinishCallback);
}
