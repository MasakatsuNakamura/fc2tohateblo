<?php
$in = fopen("php://stdin", "r");

$in_body = false;
$in_comment = false;
$no_output = 0;
while (!feof($in)) {

	$line = rtrim(fgets($in));
	
	if ($line == "AUTHOR:") {
		
		$message = [$line];
		
	} elseif ($line == "BODY:") {

		$in_body = true;

	} elseif ($line == "COMMENT:") {

		$in_comment = true;

	} elseif ($in_body && $line == "EXTENDED BODY:") {

		array_pop($message);
		$no_output = 1;
		
	} elseif ($line == "-----") {

		$in_body = false;
		$in_comment = false;

	} elseif ($line == "--------") {

		echo implode(PHP_EOL, $message);

	}

	if ($in_body && substr($line, strlen($line) - 1, 1) != ">" && $line != "BODY:") {
		$line .= "<br>";
	}

	while ($no_output == 0) {
		if (!($in_comment && preg_match("/^(SECRET:|PASS:)/", $line))) {
			if ($in_comment) {
				$line = preg_replace("/^TITLE:/", "タイトル:");
			}
			array_push($message, $line);
		}
	}
	$no_output--;
}
