<?php
namespace GGChat\classe;

use GGChat\classe\Page;
use GGChat\includes\Dbh;
use PDO;

class ChatGroupe extends Page
{
  
  public $title;

  public function __construct() // Constructeur demandant 2 paramètres
  {
      parent::__construct();
      
      $this->title= 'Groupe Chat';
    
  }

    public function groupChatPrint()
    {
        //header("Refresh:5");

        $DbhObject = new Dbh();

        $dbh = $DbhObject->getDbh(); 

        $sql = "SELECT * FROM groupe";
        $comp = $dbh->query($sql);
        $tableau = $comp->fetchAll(PDO::FETCH_ASSOC);
        $this->doc.='<ul>';
        $reversed = array_reverse($tableau);
        foreach ($reversed as $row) 
        {
            $this->doc.='<li><a href="chatGroupeDetail.php?groupe='.$row["groupe_nom"].'">'.$row["groupe_nom"].'</a></li>' ;
        }
        $this->doc.='</ul>';
        
        
            
        
        
    }


}