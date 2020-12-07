<?php
namespace GGChat\classe;

class Page
{

    protected $title;
    public $currentPage;
    public $doc; 
    
    public function __construct() // Constructeur
    {
        
        
        $this->title = '';
        $this->currentPage = '';
        $this->doc = '';
    
    }
    
    public function affiche($doc)
    {

	   echo $doc;
        
    }
    
    public function htmlHead()
    {
        $this->doc .= '<!DOCTYPE html>
        <html lang="fr"> 
        <head>';
        $this->doc .='
        <title>'.$this->title.'</title>
        <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <script src="js/script.js"></script>';
        $this->doc .= '
        </head>
        <body>';

       

    }
    public function htmlTopNav($currentPage)
    {
        
    


    $this->doc .= '<div style="box-shadow: rgba(0, 0, 0, 0.3) 9px -5px 84px 21.9939px;" class="topnav" id="myTopnav">
        <a class="button" href="index.php"  >Accueil</a>
        <a class="button" href="help.php"  >Aide</a>
    
    
        ';//<a href="map.php"  >Carte</a>
       if (isset($_SESSION['u_id']))
        {   
           $this->doc .='
            <a class="button" href="contact.php" >Contact</a>
            <a class="button" href="membre.php" >Membre</a>
            <a class="button" href="chatGroupe.php"  >Group Chat</a>';
            $this->doc .='<form class="logout"'.$currentPage.'" method="POST">
            <input name="log_id" type="hidden" value="logout">
            <button id="logout" type="submit" name="submit">Logout</button>';
            $this->doc .= '<b id="nameUser">'.$_SESSION["u_uid"].'</b>';
           $profilePic='img_user/'.$_SESSION['u_id'].'_img.png';
            if (file_exists ($profilePic))
            {

                $this->doc .= "<a href='membre.php' ><img id ='profilePicTop' src='$profilePic' alt='Profile picture'></a>";

            }
            else
            {

                $this->doc .="<a href='membre.php' ><img id ='profilePicTop' src='img/compte_img.png' alt='Profile picture'></a>" ;

            }
           $this->doc .='</form>';
        }
        else
        {
            $this->doc .='
            <a class="button" href="signup.php" >Sign up</a>';
            $this->doc .= ' <form class="login" action="'.$currentPage.'" method="POST" >
            <input type="text" name="uid" placeholder="Username/e-mail">
            <input type="password" name="pwd" placeholder="password">
            <input name="log_id" type="hidden" value="login">
            <button name="submit" type="submit">login</button></form>';
        } 
     
        $this->doc .=     '
        <a href="javascript:void(0);" class="icon button" onclick="myFunction()">
        <i class="fa fa-bars"></i>
        </a>
        </div>';
        
       
        
    

    }
    
    public function Htmlclose()
    {
        $this->doc .= '</body></html>';
    }

    

}








