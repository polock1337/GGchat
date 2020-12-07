<?php
namespace GGChat\classe\view;

use GGChat\classe\Page;

class Help extends Page
{
  
    public $title;
    
    public function __construct() // Constructeur
    {
        parent::__construct();
        $this->title = 'Aide';

    }
    
    
   public function contenuPresentation()
    {
        $this->doc .= '<h1 id="titreAideh1">Aide</h1>';
        $this->doc .= '<h2 id="titreAideh2">Comment faire pour s\'inscrire ?</h1>';
        $this->doc .= '<p class="center">Pour s\'inscrire il faut aller sur la page Sign up. Si vous avez déja un compte il sufi d\'entrer vos informations en haut à droite et cliquer sur login.</p>';
        $this->doc .= '<h2 id="titreAideh2">Comment faire pour chatter ?</h1>';
        $this->doc .= '<p class="center">Pour chatter il faut être inscrit un menu group chat sert à choisir un groupe de chat et chattez.</p>';
        $this->doc .= '<h2 id="titreAideh2">Vous avez d\'autre question ?</h1>';
        $this->doc .= '<p class="center">Vous pouvez envoyer vos questions dans les salons ou bien envoyez un mail à ggchat@gmail.com</p>';
      
    }
}