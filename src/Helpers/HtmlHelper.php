<?php
class HtmlHelper
{
	public static function tag($tag, array $params = [], $selfClose = false)
	{
		$html = '<' . $tag;
		foreach ($params as $k => $v)
			$html .= ' ' . $k . '="' . $v . '"';
		if ($selfClose)
			$html .= '/';
		$html .= '>';
		return $html;
	}

	public static function tagClose($tag)
	{
		return '</' . $tag . '>';
	}

	public static function passwordTag($name, array $params = [])
	{
		$otherParams = [
			'type' => 'password',
			'name' => $name,
			'value' => InputHelper::getPost($name)
		];
		return self::tag('input', array_merge($params, $otherParams));
	}

	public static function textInputTag($name, array $params = [])
	{
		$otherParams = [
			'type' => 'text',
			'name' => $name,
			'value' => InputHelper::getPost($name)
		];
		return self::tag('input', array_merge($params, $otherParams));
	}
}