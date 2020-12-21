<?php
namespace GGChat;

require_once ('includes/dbh.inc.php');
require_once('classe/Page.php');//pour la classe page
require_once('classe/checker/Login.php');//pour le login 
require_once('classe/checker/Logout.php');//pour le lougout
require_once('classe/view/Options.php');//pour l'écran options


use GGChat\classe\Page as Page;
use GGChat\classe\checker\Login as Login;
use GGChat\classe\checker\Logout as Logout;
use GGChat\classe\Options as Options;

session_start();


$LoginTopNav = new Login();//création login

$LoginTopNav->check();//check pour le login submit

$LogoutTopNav = new Logout();//création login

$LogoutTopNav->check();//check pour le logout submit


//--------------------------index--------------------------------//


$PageOptionsPrincipal = new Options(); 

$PageOptionsPrincipal->htmlHead($PageOptionsPrincipal->title);

$PageOptionsPrincipal->htmlTopNav('options.php');


$PageOptionsPrincipal->OptionsContenu();


$PageOptionsPrincipal->Htmlclose();

$PageOptionsPrincipal->affiche($PageOptionsPrincipal->doc);





