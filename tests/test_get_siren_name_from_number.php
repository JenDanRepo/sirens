#!/usr/bin/php

<?php

require('../phpsqlsearch_dbinfo.php');
require('../php_siren_lib.php');

$siren_name = get_siren_name_from_number(1);

if ($siren_name == '22nd & Carolina'){
	echo "passed!";
} else {
	echo "failed";
}

?>
