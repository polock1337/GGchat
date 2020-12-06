<?php
namespace GGChat\classe\view;

use GGChat\classe\Page;


class Membre extends Page
{
  
    public $title;

    public function __construct() // Constructeur demandant 2 paramètres
    {
        parent::__construct();

        $this->title= 'Membre';

    }
    public function formulaire()
    {
        
        $profilePic='img_user/'.$_SESSION['u_id'].'_img.png';

        $this->doc .='<div class="grid-container">';
            if(file_exists ($profilePic))
            {
            
                $this->doc .= "<div class='grid-item'><img id ='profilePicMembre'
                src='$profilePic' alt='Profile picture'>
                </div>";
                
            }
            else
            {

                $this->doc .="<div class='grid-item'>
                <img id ='profilePicTopMembre' src='img/compte_img.png' alt='Profile picture'>
                </div>" ;

            }
            $this->doc .='
            <div class="grid-item"><form method="POST" action="membre.php" enctype="multipart/form-data">
        <label for="profile_pic">Icône de profile (JPG ou PNG) :</label><br />
        <input type="file" name="profile_pic" id="profile_pic" /><br />
     
        <input type="submit" name="submit" value="Envoyer" />
        <input name="f_id" type="hidden" value="profilePic">
        </form>';
        $this->doc .= '<label >Rename username</label><br />
        <div class="grid-item"><form class="computerSign" action="membre.php" method="POST" >
            <input type="text" name="userRenew" placeholder="New username">
            <button type="submit" name="submit">Envoyer</button>
            <input name="f_id" type="hidden" value="Rename">
            </form></div></div>';
    
    }

}