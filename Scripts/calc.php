#!/usr/bin/php
<?php
error_reporting(0);

$content = '';
$fp = fopen('php://stdin', 'r');
while ($line = fgets($fp, 4096)) $content .= $line;
fclose($fp);

if (!empty($content)) {

	/* is this a hex color? */
	if ($content{0} == '#') {
		
		$formula = trim($content);
		$formula = trim($formula,'#');
		$formula = trim($formula,'%');
		
		if (strpos($formula,'-') !== false) {
		
			list($color,$percent) = explode('-',$formula);
			$percent = ($percent / 100) * 256;
			echo hex_color_mod(trim($color),$percent);
		
		} elseif (strpos($formula,'+') !== false) {
		
			list($color,$percent) = explode('+',$formula);
			$percent = ($percent / 100) * 256;
			echo hex_color_mod(trim($color),-$percent);
		
		} elseif (strpos($formula,' ') !== false) {
		
			list($color,$percent) = explode(' ',$formula);
			$percent = ($percent / 100) * 256;
			echo hex_color_mod(trim($color),-$percent);
		
		} else {
			/* beats me? */
			echo $content;
		}
		
	} else {
		/* guess not */
		$cf_DoCalc = create_function("", "return (".$content.");");
		echo $cf_DoCalc();
	}

}

/**
 * Change the brightness of the passed in color
 *
 * $diff should be negative to go darker, positive to go lighter and
 * is subtracted from the decimal (0-255) value of the color
 * 
 * @param string $hex color to be modified
 * @param string $diff amount to change the color
 * @return string hex color
 */
/* https://gist.github.com/alexkingorg/1191954 */
function hex_color_mod($hex, $diff) {
	$rgb = str_split(trim($hex, '# '), 2);
 
	foreach ($rgb as &$hex) {
		$dec = hexdec($hex);
		if ($diff >= 0) {
			$dec += $diff;
		}
		else {
			$dec -= abs($diff);			
		}
		$dec = max(0, min(255, $dec));
		$hex = str_pad(dechex($dec), 2, '0', STR_PAD_LEFT);
	}
 
	return '#'.implode($rgb);
}