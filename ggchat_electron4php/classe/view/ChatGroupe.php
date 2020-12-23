<?php
namespace GGChat\classe;

use GGChat\classe\Page;
use GGChat\classe\dao\ChatGroupeDAO;
use PDO;

class ChatGroupe extends Page
{
  
  public $title;

  public function __construct() 
  {
      parent::__construct();
      $this->title= 'Groupe Chat';
  }
    public function groupChatPrint()
    {
        
        $this->doc.='<ul>';
        $chatGroupeDAO = new ChatGroupeDAO();
        $tableau = $chatGroupeDAO->getGroupe();
        $reversed = array_reverse($tableau);
        
        foreach ($reversed as $row) 
        {
            $this->doc.='<li><a href="chatGroupeDetail.php?groupe='.$row["groupe_nom"].'">'.$row["groupe_nom"].'</a></li>' ;
        }
        $this->doc.='</ul>';
        
    }


}