<?php
function outLines(&$array) {
	echo implode(PHP_EOL, $message);
	$array = [];
}

$in = fopen("php://stdin", "r");

$in_body = false;
$in_comment = false;
$no_output = 0;
$message = [];
while (!feof($in)) {

	$line = rtrim(fgets($in));

	if ($line == "BODY:" || $line == "EXTENDED BODY:") {
		outLines($message);
		$in_body = true;
	} elseif (preg_match("/^CONVERT BREAKS: (.*)$/", $line, $match) == 1) {
		$line_break = $match[1];
	} elseif ($line == "COMMENT:") {
		$in_comment = true;
	} elseif ($line == "-----") {
		outLines($message);
		$in_body = false;
		$in_comment = false;
	} elseif ($line == "--------") {
		outLines($message);
	}

	if (!($in_comment && preg_match("/^(SECRET:|PASS:)/", $line))) {
		if ($in_comment) {
			$line = preg_replace("/^TITLE:/", $line, "タイトル:");
		}
	}
	array_push($message, $line);
}
