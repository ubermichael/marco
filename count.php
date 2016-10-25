<?php

require 'vendor/autoload.php';

$iterator = new Nines\Marco\FileIterator($argv[1]);
while ($record = $iterator->current()) {
	$iterator->next();
}
print $iterator->key();