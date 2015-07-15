<?php

return [
	'sourcePath' => __DIR__ . '/../',
	'messagePath' => __DIR__,
	'languages' => [
		'ro',
	],
	'translator' => 'Yii::t',
	'sort' => false,
	'overwrite' => true,
	'removeUnused' => false,
	'only' => ['*.php'],
	'except' => [
		'.svn',
		'.git',
		'.gitignore',
		'.gitkeep',
		'.hgignore',
		'.hgkeep',
		'/messages',
		'/tests',
	],
	'format' => 'php',
];
