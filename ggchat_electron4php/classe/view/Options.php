<?php
namespace GGChat\classe;



use GGChat\classe\Page;
use GGChat\classe\xml;
use PDO;

class Options extends Page
{
	public $title;
	
	public function __construct()
	{
		$this->title='Options';
	}
	public function OptionsContenu()
	{
		$xmlLocation = "classe\xml\options.xml";
		
		$xml = Simplexml_load_file($xmlLocation);
		
		$this->doc .= '
		
		<form action="classe\xml\SaveOptions.php" method="post">
		<input type="radio" name="Theme" value="style.css"';
		if ($xml == 'style.css')
			{$this->doc .=' checked';}
		$this->doc .='
		>Dark
		<input type="radio" name="Theme"';
		if ($xml == 'altStyle.css')
			{$this->doc .="checked";}
		$this->doc .='
		value="altStyle.css">light
		<input type="submit" value="sauvegarder"></form>';
		
	}
}