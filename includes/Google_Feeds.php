<?php

class Google_Feeds {
	public static $baseurl = 'https://ajax.googleapis.com/ajax/services/feed/load?v=1.0&';
	public static function get($url, $results = 5) {
		$ip = $_SERVER['REMOTE_ADDR'];
		$url = static::$baseurl . http_build_query(array(
			'userip' => $ip,
			'q' => $url,
			'num' => $results
		));
		
		// $ch = curl_init();
		// curl_setopt($ch, CURLOPT_URL, $url);
		// $result = curl_exec($ch);
		// curl_close($ch);
		$result = file_get_contents($url);
		return json_decode($result);
	}
}