<?php
namespace GGChat\classe;

use GGChat\classe\Page;
use GGChat\includes\Dbh;
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
                $DbhObject = new Dbh();

                $dbh = $DbhObject->getDbh();

                $stmt = $dbh->query("SELECT id FROM groupe WHERE groupe_nom='".$_GET["groupe"]."' LIMIT 1"); 
                $group_row = $stmt->fetch();
                if($group_row['id'])
                {
                    $sql= $dbh->prepare("INSERT INTO public.message_groupe 
                    (groupe_fkey,membre_fkey,message_groupe_contenu, timestamp) VALUES (:group_id,".$_SESSION['u_id'].",:message_groupe_contenu, to_char(current_timestamp, 'yyyy-mm-dd hh:mi:ss'));");
                    $sql->bindParam(':group_id',$group_row['id'] );
                    $sql->bindParam(':message_groupe_contenu',$message_groupe_contenu );
    
                    $sql->execute();
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
        //header("Refresh:5");

        $DbhObject = new Dbh();
        $dbh = $DbhObject->getDbh();

        $stmt = $dbh->query("SELECT id FROM groupe WHERE groupe_nom='".$_GET["groupe"]."' LIMIT 1"); 
        $group_row = $stmt->fetch();

        if($group_row)
        {
            $sql = "SELECT * FROM message_groupe Where groupe_fkey=".$group_row['id'];
            $comp = $dbh->query($sql);
            $tableau = $comp->fetchAll(PDO::FETCH_ASSOC);

            $this->doc .= '<div class="chat">';

            $reversed = array_reverse($tableau);
            foreach ($reversed as $row) 
            {
                $sql = "SELECT * FROM membre WHERE id=".$row['membre_fkey'];
                $comp = $dbh->query($sql);
                $data = $comp->fetch(PDO::FETCH_ASSOC);
                
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
                $this->doc .= "<p>".$name.$pic." : ".$row["message_groupe_contenu"]."</p>";
            
                
                
            }
            $this->doc.='</div>';
        }
        else{
            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
            exit(); 
        }
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