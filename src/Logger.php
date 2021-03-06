<?php
class Logger
{
	private static $fh;

	public static function logException(Exception $e)
	{
		self::log($e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
	}

	public static function log($msg)
	{
		$msg = explode("\n", str_replace("\r", '', $msg));
		$prefix = date('[Y-m-d H:i:s] ');
		$suffix = PHP_EOL;
		foreach ($msg as $msgLine)
		{
			self::open();
			self::write($prefix . $msgLine . $suffix);
			self::close();
		}
	}

	private static function open()
	{
		$config = getConfig();
		$logPath = $config->rootDir . DIRECTORY_SEPARATOR . $config->main->logPath;
		self::$fh = fopen($logPath, 'ab');
	}

	private static function write($data)
	{
		if (self::$fh === null)
			throw new SimpleException('Error: handle cannot be null.');
		fwrite(self::$fh, $data);
	}

	private static function close()
	{
		if (self::$fh !== null)
		{
			fclose(self::$fh);
			self::$fh = null;
		}
	}
}
