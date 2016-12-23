<?php

/**
 * Возвращает хост сайта на основании конфигурации
 *
 * @return string
 */
function host(){
	$url_data = parse_url(config('app.url'));
	return isset($url_data[ 'host' ]) ? $url_data[ 'host' ] : $url_data[ 'path' ];
}