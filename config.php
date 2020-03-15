<?php
$config = [
	'db' => [
		'host' => 'localhost',
		'username' => 'beegee',
		'password' => 'beegee_superpass',
		'database' => 'beegee',
		],
	'routes' => [
		'user' => [
			'auth',
			'logout',
			'admin_create',
			],
		'note' => [
			'index' => ['default' => ''],
			'add',
			'edit',
			'aquire',
			],
		],
	'default_route' => 'note',
	];
	
return $config;
?>