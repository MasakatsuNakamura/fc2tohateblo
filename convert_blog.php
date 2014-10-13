<?php
$in = fopen("php://stdin", "r");

$in_body = false;
$in_comment = false;
$no_output = 0;
while (!feof($in)) {

	$line = rtrim(fgets($in));

	if ($line == "BODY:") {

		$in_body = true;

	} elseif ($line == "EXTENDED BODY:") {

		$no_output = 3;

	} elseif ($line == "COMMENT:") {

		$in_comment = true;

	} elseif ($line == "-----") {

		$in_body = false;
		$in_comment = false;

	}

	if ($in_body && substr($line, strlen($line) - 1, 1) != ">" && $line != "BODY:") {
		$line .= "<br>";
	}

	if ($no_output > 0) {
			$no_output--;
	} else {
		if (!($in_comment && preg_match("/^(SECRET:|PASS:)/", $line))) {
			echo $line . PHP_EOL;
		}
	}
}
