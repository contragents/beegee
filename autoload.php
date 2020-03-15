<?php
spl_autoload_register(function ($class_name) {
    $Exploded_class=explode('\\',$class_name);
	include $Exploded_class[count($Exploded_class)-1] . '.php';
});
?>