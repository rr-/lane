<?php
define('DS', DIRECTORY_SEPARATOR);
$rootDir = __DIR__ . DS . '..' . DS;

//basic include calls, autoloader init
require_once $rootDir . 'lib' . DS . 'chibi-core' . DS . 'Facade.php';
\Chibi\AutoLoader::init([__DIR__, $rootDir . 'lib' . DS . 'chibi-sql']);

//load config manually
$configPaths =
[
	$rootDir . DS . 'data' . DS . 'config.ini',
	$rootDir . DS . 'data' . DS . 'local.ini',
];
$config = new \Chibi\Config();
foreach ($configPaths as $path)
	if (file_exists($path))
		$config->loadIni($path);
\Chibi\Registry::setConfig($config);
\Chibi\Facade::init();
\Chibi\Registry::getContext()->rootDir = $rootDir;

\Chibi\Database::connect('sqlite', $rootDir . DS . 'data' . DS . 'db.sqlite', null, null);