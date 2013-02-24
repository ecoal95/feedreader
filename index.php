<?php 
/** Algunas constantes de utilidad */
define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', dirname(__FILE__) . DS);
if( '/' === DS ) {
	define('BASE_ABSOLUTE_URL', str_replace($_SERVER['DOCUMENT_ROOT'], '', BASE_PATH));
} else {
	define('BASE_ABSOLUTE_URL', str_replace(DS, '/', str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace(DS, '/', BASE_PATH))));
}


/** Autocarga de clases en plan sencillo */
spl_autoload_register(function($class) {
	require BASE_PATH . 'includes/' . $class . '.php';
});

/** Obtener la configuración */
$config = (require BASE_PATH . 'includes/config.php');

/** Queremos registrar los clicks? */
define('TRACK_CLICKS', isset($config['track_clicks']) ? $config['track_clicks'] : false);

/** incluir las funciones de formato */
require BASE_PATH . 'includes/functions.php';

/** Configurar la caché para que expire en una hora */
Cache::configure(array(
	'cache_path' => BASE_PATH . 'storage/cache',
	// 1 hora
	'expires' => 1
));

/** 
 * Sólo usar la clase con cURL si no tenemos una copia completa fresca desde la caché
 */
if( ! $items = Cache::get('NetK_full_items', true) ) {
	NetK::start($config['feeds'], $config['posts_per_feed']);
	// Por ahora sólo soportado date
	NetK::orderItems('date');
	NetK::setFeedTemplate(BASE_PATH . 'includes/template-fullfeed.php');
	NetK::setItemTemplate(BASE_PATH . 'includes/template-entry.php');

	ob_start();
	NetK::renderItems();
	$items = ob_get_clean();

	Cache::put('NetK_full_items', $items, true);
}
?><!DOCTYPE html>
<!--[if lt IE 7 & (!IEMobile)]>
<html class="ie ie6 lt-ie7 lt-ie8 lt-ie9 no-js">
<![endif]-->
<!--[if (IE 7) & (!IEMobile)]>
<html class="ie ie7 lt-ie8 lt-ie9 no-js">
<![endif]-->
<!--[if (IE 8) & (!IEMobile)]>
<html class="ie ie8 lt-ie9 no-js">
<![endif]-->
<!--[if IE 9 & (!IEMobile)]>
<html class="ie ie9 no-js">
<![endif]-->
<!--[if (gt IE 9) | (IEMobile) | !(IE)  ]><!-->
<html class="no-js">
<!--<![endif]-->
<head prefix="og: http://ogp.me/ns#">
	<meta charset="utf-8">

	<title>NetK | Réplica con PHP | Emilio Cobos</title>
	<meta property="og:title" content="NetK">

	<meta name="description" content="NetK es una red de artículos de blogs externos que te pueden ser de ayuda. Ésta es una réplica con PHP, pero el NetK original lo podéis ver en http://ksesocss.blogspot.com/2012/11/netK.html">
	<meta property="og:description" content="NetK es una red de artículos de blogs externos que te pueden ser de ayuda. Ésta es una réplica con PHP, pero el NetK original lo podéis ver en http://ksesocss.blogspot.com/2012/11/netK.html">

	<meta name="viewport" content="width=device-width">

	<link rel="stylesheet" href="css/style.css">
	<script src="js/html5.js"></script>
</head>
<body>
	<div class="header-outer">
		<header role="banner" class="site-header container">
			<h1 class="site-title"><a href="<?php echo BASE_ABSOLUTE_URL ?>">NetK</a></h1>
		</header>
	</div>
	<?php /** Tabla de contenidos, sólo si renderizamos los feeds y no los items */ ?>
	<!-- <ul class="toc" id="toc">
		<?php foreach ($config['feeds'] as $url => $name): ?>
			<li id="<?php echo nameToId($name) ?>-toc"><a href="#<?php echo nameToId($name) ?>"><?php echo $name ?></a></li>
		<?php endforeach ?>
	</ul> -->
	<ul role="main" class="netk-items container">
		<?php /** Mostrar los elementos desde la caché */ 
			// NetK::renderItems();
			echo $items;
		?>
	</ul>
	<?php // NetK::renderFeeds() ?>
</body>
</html>
