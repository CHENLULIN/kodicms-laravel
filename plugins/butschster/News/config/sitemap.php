<?php

return [
	[
		'name' => 'News',
		'label' => 'butschster:news::core.title.list',
		'url' => route('backend.news.list'),
		'permissions' => 'news.index',
		'priority' => 100,
		'icon' => 'newspaper-o'
	]
];
