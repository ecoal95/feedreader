<?php

return array(
	/** Lista de los feeds */
	'feeds' => array(
		'http://emiliocobos.net/feed/' => 'Emilio Cobos',
		'http://ksesocss.blogspot.com/feeds/posts/default' => 'Kseso',
		'http://oloblogger.com/feeds/posts/default' => 'Oloblogger',
		'http://css-tricks.com/feed/' => 'CSS-Tricks',
		'http://feeds.feedburner.com/html5rocks' => 'HTML5 Rocks',
		// ...
	),

	/** Registrar los clicks en el archivo storage/log.txt */
	'track_clicks' => true,

	/** Posts a mostrar por cada feed */
	'posts_per_feed' => 5,
	
	/** No implementadas (usaremos el resumen automático de google) */
	// 'excerpt_length' => 50,
	// 'show_bloginfo' => true,

);