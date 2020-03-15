<?php

namespace View;

class BaseView
{
		
	public static function render($html)
	{
		include 'HeaderTemplate.php';
		print $html;
		include 'FooterTemplate.php';
	}
}
?>