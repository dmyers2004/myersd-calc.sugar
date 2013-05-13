#!/usr/bin/php
<?php
error_reporting(0);

$content = '';
$fp = fopen('php://stdin', 'r');
while ($line = fgets($fp, 4096))
	$content .= $line;
fclose($fp);

if (!empty($content)) {
  $cf_DoCalc = create_function("", "return (".$content.");");
  echo $cf_DoCalc();
}