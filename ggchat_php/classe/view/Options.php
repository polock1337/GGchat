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
		<form class="option" action="classe\xml\SaveOptions.php" method="post">
		<label>Light pink : </label>
		<input type="radio" name="Theme" value="styleLightPink.css"';
		if ($xml == 'styleLightPink.css')
			{$this->doc .=' checked';}

		$this->doc .='>
		<label>Dark : </label>
		<input type="radio" name="Theme"';
		if ($xml == 'styleDark.css')
			{$this->doc .="checked";}
		$this->doc .='
		value="styleDark.css">';
		$this->doc .='
		<label>Classic : </label>
		<input type="radio" name="Theme"';
		if ($xml == 'styleClassic.css')
			{$this->doc .="checked";}
		$this->doc .='
		value="styleClassic.css">
		<input type="submit" value="sauvegarder"></form>';
		
		
	}
}