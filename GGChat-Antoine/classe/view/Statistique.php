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
    

    public static function listerContenu()
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

        $this->doc.='<a>test</a>';

        /*echo $resultat["groupe_fkey"];
        echo $resultat["nombre"];
        //$this->doc.='<ul>';
        $this->doc.='<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <div class="chart-container" style="position: relative; height:20vh; width:40vw;">
              <canvas id="graphique" ></canvas>
        </div>
        
        <script>
        var donnees = [<?php echo $nombreGroup1; ?>, <?php echo $nombreGroup2; ?>, <?php echo $nombreGroup3; ?>];
        var etiquettes = ["japonaise", "française", "allemande"];
        var couleurs = ["rgba(255, 99, 132, 0.9)","rgba(54, 162, 235, 0.9)", "rgba(255, 206, 86, 0.9)"]
        
        var cible = document.getElementById("graphique");
        var graphiqueTarte = new Chart(cible, {
            type: "pie",
            data: {
                labels: etiquettes,
                datasets: [{
                    label: "Contenu par catégorie",
                    data: donnees,
                    backgroundColor: couleurs
                }]
            },
            options: {
                responsive: true
            }
        });
        </script>';
        //$this->doc.='</ul>';*/


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

