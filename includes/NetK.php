<?php
class NetK {
	public static $feeds = array();
	public static $current_feed = 0;
	public static $content = array();
	public static $items = array();
	public static $feedTemplate;
	public static $itemTemplate;
	public static function start($feeds, $posts_per_feed = 5) {
		self::$feeds = $feeds;
		foreach ($feeds as $url => $nombre) {
			self::$content[$url] = array(
				'name' => $nombre,
				'url' => $url,
				'latest_articles' => array(),
			);

			// Cogemos los 5 últimos artículos
			$latest = Google_Feeds::get($url, $posts_per_feed);
			$latest = json_decode($latest);
			self::$content[$url]['info'] = $latest;
			self::$items = array_merge(self::$items, $latest->entries);
		}
	}

	public static function setFeedTemplate($template) {
		self::$feedTemplate = $template;
	}

	public static function setItemTemplate($template) {
		self::$itemTemplate = $template;
	}


	public static function renderFeeds() {
		foreach(self::$content as $url => $_feed) {
			$feed = $_feed['info'];
			$name = $_feed['name'];
			include self::$feedTemplate;
		}
	}

	public static function orderItems($by = 'date') {
		switch ($by) {
			case 'date':
			uasort(self::$items, function($a, $b) {
				return strtotime($a->publishedDate) < strtotime($b->publishedDate);
			});				
			break;
		}
	}

	public static function renderItems($num = -1) {
		$i = 0;
		foreach (self::$items as $entry) {
			if( $i === $num ) {
				return;
			}
			include self::$itemTemplate;
			$i++;
		}
	}
}