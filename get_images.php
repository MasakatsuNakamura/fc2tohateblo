<?php
$in = fopen("images_list.txt", "r");

while (!feof($in)) {
	$url = rtrim(fgets($in));
	preg_match("#/([^/]*)$#", $url, $matches);
	if (count($matches) > 0) {
		$fn = $matches[1];
		$data = file_get_contents($url);
		file_put_contents($fn, $data);
	}
}



