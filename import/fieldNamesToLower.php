<?php
$file = file("site_contacts.sql");

foreach ($file as $line)
{
	$rep = '${1}';
	$line = preg_replace_callback('/\`[0-9A-Za-z_]+\`/',create_function(
            // single quotes are essential here,
            // or alternative escape all $ as \$
            '$matches',
            'return strtolower($matches[0]);'
        ),$line);
	echo $line."<br />";
}

exit;
