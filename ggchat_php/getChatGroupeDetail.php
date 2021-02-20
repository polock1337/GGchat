<?php
namespace GGChat;

session_start();

require_once('includes/dbh.inc.php');
require_once('classe/Page.php');//pour la classe page
require_once('classe/checker/Login.php');//pour le login 
require_once('classe/checker/Logout.php');//pour le lougout
require_once('classe/dao/ChatGroupeDetailDAO.php');//pour chat
require_once('classe/view/ChatGroupeDetail.php');//pour chat

use GGChat\classe\Page as Page;
use GGChat\classe\checker\Login as Login;
use GGChat\classe\checker\Logout as Logout;
use GGChat\classe\ChatGroupeDetail as ChatGroupeDetail;

$PageChatPrincipal = new ChatGroupeDetail(); 

$PageChatPrincipal->chatPrint();

$PageChatPrincipal->affiche($PageChatPrincipal->doc);

?>