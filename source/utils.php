<?php
	
	/* utils.php - fisier ce contine diverse functii utile proiectului. */

	/* https://stackoverflow.com/a/4356295 */
	function generateRandomString($len = 10) {
	    $chrs = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $chrsLen = strlen($chrs);
	    $ranStr = '';

	    for ($i = 0; $i < $len; $i ++) {
	        $ranStr .= $chrs[rand(0, $chrsLen - 1)];
	    }

	    return $ranStr;
	}
?>