<?php
namespace GGChat\classe\dao;

use GGChat\includes\Dbh;
use PDO;

class ChatPriveDAO
{
    public function getIdWhereMembreUid($membre)
    {
        $DbhObject = new Dbh();
        $dbh = $DbhObject->getDbh(); 
        $sql = "SELECT id FROM membre WHERE membre_uid='".$membre."' LIMIT 1";
        $requete = $dbh->prepare($sql);
        $requete->execute();
        $data = $requete-> fetch();

        return $data;
    }
    public function getMembreWhereId($row)
    {
        $DbhObject = new Dbh();
        $dbh = $DbhObject->getDbh(); 
        $sql = "SELECT * FROM membre WHERE id=".$row['membre_receveur_fkey'];
        $requete = $dbh->prepare($sql);
        $requete->execute();
        $data = $requete-> fetch();

        return $data;
    }
    public function insertMsgPrive($id,$message_prive_contenu,$uid){
        $DbhObject = new Dbh();
        $dbh = $DbhObject->getDbh();
        $sql= $dbh->prepare("INSERT INTO public.message_prive 
        (public_id,membre_envoyeur_fkey,membre_receveur_fkey,message_prive_contenu, timestamp) VALUES (:public_id,".$uid.",:membre_receveur_id,:message_prive_contenu, to_char(current_timestamp, 'yyyy-mm-dd hh:mi:ss'));");
        $sql->bindParam(':membre_receveur_id',$id );
        $sql->bindParam(':message_prive_contenu',$message_prive_contenu );
        $sql->bindParam(':public_id',uniqid());

        $sql->execute();
    }
    
    public function getMsgPrive($id,$uid)
    {
        
        $DbhObject = new Dbh();
        $dbh = $DbhObject->getDbh(); 
        $sql = "SELECT * FROM message_prive Where membre_envoyeur_fkey=".$id." AND membre_receveur_fkey=".$uid." OR membre_receveur_fkey=".$id." AND membre_envoyeur_fkey=".$uid;
        $requete = $dbh->prepare($sql);
        $requete->execute();
        $data = $requete-> fetchAll();

        return $data;
    }
    public function getLastMessage($currentUser_id,$membre_id){

        $DbhObject = new Dbh();
        $dbh = $DbhObject->getDbh();
        $sql = $dbh->prepare("SELECT * FROM message_prive where membre_envoyeur_fkey = :membre_id or membre_envoyeur_fkey = :currentUser_id  or membre_receveur_fkey = :membre_id or membre_receveur_fkey = :currentUser_id  ORDER BY id DESC LIMIT 1;");

        $sql->bindParam(':currentUser_id',$membre_id);
        $sql->bindParam(':membre_id',$membre_id);
        $sql->execute();
        $data = $sql-> fetch();

        return $data;

    }
    public function getMessageBetweenId($currentUser_id,$membre_id,$id1,$id2)
    {
        $DbhObject = new Dbh();
        $dbh = $DbhObject->getDbh();
        $sql = $dbh->prepare("SELECT * FROM message_prive where membre_envoyeur_fkey = :membre_id or membre_envoyeur_fkey = :currentUser_id  or membre_receveur_fkey = :membre_id or membre_receveur_fkey = :currentUser_id AND id > :id1 AND id <= :id2 ORDER BY id DESC ;");
        $sql->bindParam(':currentUser_id',$currentUser_id);
        $sql->bindParam(':membre_id',$membre_id);
        $sql->bindParam(':id1',$id1);
        $sql->bindParam(':id2',$id2);
        $sql->execute();
        $data = $sql-> fetchAll();

        return $data;
    }
    public function getMessageIdWithPublicId($public_id)
    {
        $DbhObject = new Dbh();
        $dbh = $DbhObject->getDbh();
        $sql = $dbh->prepare("SELECT id FROM message_prive where public_id = :public_id ;");
        $sql->bindParam(':public_id',$public_id);
        $sql->execute();
        $data = $sql-> fetch();

        return $data;
    }
    public function getMembreEnvoyeur($membre_envoyeur_fkey)
    {
        $DbhObject = new Dbh();
        $dbh = $DbhObject->getDbh(); 
        $sql = "SELECT * FROM membre WHERE id=".$membre_envoyeur_fkey;
        $requete = $dbh->prepare($sql);
        $requete->execute();
        $data = $requete-> fetch();

        return $data;
    }
}