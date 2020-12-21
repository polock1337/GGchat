<?php
namespace GGChat\classe;

use GGChat\classe\Page;
use GGChat\includes\Dbh;
use PDO;

class ChatPrive extends Page
{
  
  public $title;

  public function __construct() // Constructeur demandant 2 paramètres
  {
      parent::__construct();
      
      $this->title= 'Chat Prive';
    
  }
    public function chatCheck()
    {
        if (isset($_POST['f_id']))
        {
            include_once 'includes/dbh.inc.php';

            $textpg = pg_escape_string($_REQUEST['textGlobal']);
            $message_prive_contenu = htmlspecialchars($textpg);

            //error handler 
            //check empty fields 
            if (empty($message_prive_contenu))
            {


                header("location: chatPrive.php?=emptyInput&membre=".$_GET["membre"]);
                exit(); 
            }
            else
            {
                $DbhObject = new Dbh();

                $dbh = $DbhObject->getDbh();

                $stmt = $dbh->query("SELECT id FROM membre WHERE membre_uid='".$_GET["membre"]."' LIMIT 1"); 
                $prive_row = $stmt->fetch();
                if($prive_row['id'])
                {
                    $sql= $dbh->prepare("INSERT INTO public.message_prive 
                    (membre_envoyeur_fkey,membre_receveur_fkey,message_prive_contenu, timestamp) VALUES (".$_SESSION['u_id'].",:membre_receveur_id,:message_prive_contenu, to_char(current_timestamp, 'yyyy-mm-dd hh:mi:ss'));");
                    $sql->bindParam(':membre_receveur_id',$prive_row['id'] );
                    $sql->bindParam(':message_prive_contenu',$message_prive_contenu );
                    
                    $sql->execute();
                    header("location: chatPrive.php?=MsgSend&membre=".$_GET["membre"]);
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

        $stmt = $dbh->query("SELECT id FROM membre WHERE membre_uid='".$_GET["membre"]."' LIMIT 1"); 
        $prive_row = $stmt->fetch();

        if($prive_row)
        {
            $sql = "SELECT * FROM message_prive Where membre_envoyeur_fkey=".$prive_row['id']." AND membre_receveur_fkey=".$_SESSION['u_id']." OR membre_receveur_fkey=".$prive_row['id']." AND membre_envoyeur_fkey=".$_SESSION['u_id'];
            $comp = $dbh->query($sql);
            $tableau = $comp->fetchAll(PDO::FETCH_ASSOC);

            $this->doc .= '<div class="chat">';

            $reversed = array_reverse($tableau);
            foreach ($reversed as $row) 
            {
                $sql = "SELECT * FROM membre WHERE id=".$row['membre_envoyeur_fkey'];
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
                $this->doc .= "<p>".$name.$pic." : ".$row["message_prive_contenu"]."</p>";
            
                
                
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

        $this->doc .= '<form class="globalChatInput" action="chatPrive.php?membre='.$_GET["membre"].'" method="POST" >
            <input type="text" name="textGlobal" id="txt_1" placeholder="Envoyer un message"  >
            <button type="submit" name="submit">Envoyer</button>
            <input name="f_id" type="hidden" value="msgSend">
            </form>';    
    }
}