<?php
namespace GGChat\classe;

use GGChat\classe\Page;
use GGChat\classe\dao\ChatGroupeDetailDAO;
use PDO;

class ChatGroupeDetail extends Page
{
  
  public $title;

  public function __construct() // Constructeur demandant 2 paramètres
  {
      parent::__construct();
      
      $this->title= 'Groupe Chat détail';
    
  }
    public function chatCheck()
    {
        $chatGroupeDetailDAO = new ChatGroupeDetailDAO();
        if (isset($_POST['f_id']))
        {
            include_once 'includes/dbh.inc.php';

            $textpg = pg_escape_string($_REQUEST['textGlobal']);
            $message_groupe_contenu = htmlspecialchars($textpg);

            //error handler 
            //check empty fields 
            if (empty($message_groupe_contenu))
            {


                header("location: chatGroupeDetail.php?=emptyInput&groupe=".$_GET["groupe"]);
                exit(); 
            }
            else
            {
                $group_row = $chatGroupeDetailDAO->getGroupeWhereNom($_GET["groupe"]);

                if($group_row['id'])
                {
                    $insertMessageGroupe = $chatGroupeDetailDAO->insertMessageGroupe($group_row['id'],$message_groupe_contenu);

                    header("location: chatGroupeDetail.php?=MsgSend&groupe=".$_GET["groupe"]);
                    exit(); 
                }
                else{
                    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
                    exit(); 
                }
            }
        }   
    }
    public function chatPrint()
    {
        if(isset($_GET["public_id"]) && isset($_GET["groupe"]))
        {
            $this->chatPrintGroupLazy();
        }
        else if (isset($_GET["groupe"]))
        {
            $this->chatPrintGroup();
        } 
    }
    private function chatPrintGroupLazy()
    {
        $chatGroupeDetailDAO = new ChatGroupeDetailDAO();
        $group_row = $chatGroupeDetailDAO->getGroupeRow($_GET["groupe"]);
        if($group_row)
        {

            $lastMessage = $chatGroupeDetailDAO->getLastMessage($group_row['id']);
            $islastMessagesNotSame = strcmp($lastMessage['public_id'],$_GET['public_id']);

            if($islastMessagesNotSame)
            {
                $lastOldMessageID = $chatGroupeDetailDAO->getMessageIdWithPublicId($_GET['public_id']);
                $lastNewMessageID = $chatGroupeDetailDAO->getMessageIdWithPublicId($lastMessage['public_id']);
                $lastMessages = $chatGroupeDetailDAO->getMessageBetweenId($group_row['id'],$lastOldMessageID['id'],$lastNewMessageID['id']);

                foreach ($lastMessages as $rowMessage) 
                {
                    $membre = $chatGroupeDetailDAO->getMembreWhereId($rowMessage);
                
                    $profilePic='img_user/'.$membre['id'].'_img.png';
                    
                    if (file_exists ($profilePic))
                    {
                        $pic= "<img class='chatPic' src='$profilePic' alt='Profile picture'>";
                    }
                    else
                    {
                        $pic="<img class='chatPic' src='img/compte_img.png' alt='Profile picture'>" ;
                    }
                    $name = "<a>".$membre['membre_uid']."</a>";
                    $this->doc .= "<p id='".$rowMessage["public_id"]."'>".$name.$pic." : ".$rowMessage["message_groupe_contenu"]."</p>"; 
                }                
            }
            else
            {
                http_response_code(204);
            }
        }
        else{
            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
            exit(); 
        }
    }
    private function chatPrintGroup()
    {
        $chatGroupeDetailDAO = new ChatGroupeDetailDAO();
        $group_row = $chatGroupeDetailDAO->getGroupeRow($_GET["groupe"]);
        
        if($group_row)
        {
            $tableau = $chatGroupeDetailDAO->getMessageGroup($group_row);

            $reversed = array_reverse($tableau);
            foreach ($reversed as $row) 
            {
                $data = $chatGroupeDetailDAO->getMembreWhereId($row);
                
                $profilePic='img_user/'.$data['id'].'_img.png';
                
                if (file_exists ($profilePic))
                {

                    $pic= "<img class='chatPic' src='$profilePic' alt='Profile picture'>";

                }
                else
                {

                    $pic="<img class='chatPic' src='img/compte_img.png' alt='Profile picture'>" ;

                }
                $name = "<a>".$data['membre_uid']."</a>";
                $this->doc .= "<p id='".$row["public_id"]."'>".$name.$pic." : ".$row["message_groupe_contenu"]."</p>";
            
                
                
            }
            
        }
        else{
            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
            exit(); 
        }
    }
    public function chatOpen()
    {

        $this->doc .= '<div class="chat" id="chat">';   
    }
    public function chatClose()
    {

        $this->doc.='</div>';    
    }
    public function chatInput()
    {

        $this->doc .= '<form class="globalChatInput" action="chatGroupeDetail.php?groupe='.$_GET["groupe"].'" method="POST" >
            <input type="text" name="textGlobal" id="txt_1" placeholder="Envoyer un message"  >
            <button type="submit" name="submit">Envoyer</button>
            <input name="f_id" type="hidden" value="msgSend">
            </form>';    
    }
}