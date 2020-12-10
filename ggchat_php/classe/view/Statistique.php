<?php
namespace GGChat\classe;

use GGChat\classe\Page;
use GGChat\includes\Dbh;
use PDO;

class Statistique extends Page
{
  public $title;

  public function __construct() // Constructeur demandant 2 paramètres
  {
      parent::__construct();
      
      $this->title= 'Statistique';
    
  }
    

    public function listerContenu()
    {
        $DbhObject = new Dbh();
        $dbh = $DbhObject->getDbh();

        $MESSAGE_SQL_CONTENU = "SELECT COUNT(id) as nombre, groupe_fkey FROM public.message_groupe GROUP BY groupe_fkey;";
        $requeteListeContenu = $dbh->prepare($MESSAGE_SQL_CONTENU);
        $requeteListeContenu->execute();
        $listeContenu = $requeteListeContenu-> fetchall();
        //return $listeContenu;

        foreach($listeContenu as $resultat)
        {

          if($resultat["groupe_fkey"] == "1")
          {
            $nombreGroup1 = $resultat["nombre"];
          }
          if($resultat["groupe_fkey"] == "2")
          {
            $nombreGroup2 = $resultat["nombre"];
          }
          if($resultat["groupe_fkey"] == "3")
          {
            $nombreGroup3 = $resultat["nombre"];
          }
        }

        //$this->doc.='<a>test</a>';

        /*echo $resultat["groupe_fkey"];
        echo $resultat["nombre"];
       $this->doc.='<ul>';*/
       $this->doc.='<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
       <h1 style="text-align: center; color: white;">Statistique</h1>
       <h2 style="text-align: center; color: white;">Nombre de messages par groupe de discussion</h2>
       <div class="chart-container" style="position: relative; height:20vh; width: 100%; text-align:center">
              <canvas id="graphique" style="display: inline;" ></canvas>
      </div>
      <script>
            var donnees = ['.$nombreGroup1.', '.$nombreGroup2.', '.$nombreGroup3.'];
            var ctx = document.getElementById("graphique").getContext("2d");
            var chart = new Chart(ctx, {
          // The type of chart we want to create
          type: "doughnut",

          // The data for our dataset
          data: {
              labels: ["Groupe Sport", "Groupe informatique", "Groupe General"],
              datasets: [{
                  label: "My First dataset",
                  backgroundColor: ["rgba(4, 199, 82)","rgba(4, 193, 199, 0.9)", "rgba(255, 206, 86, 0.9)"],
                  borderColor: "rgb(0, 0, 0)",
                  data: donnees
              }]
          },

          // Configuration options go here
          options: {}
          });
          </script>';


    }


    /*public function groupChatPrint()
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
        
        
            
        
        
    }*/


}

