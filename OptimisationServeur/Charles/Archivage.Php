<?php
//namespace GGChat\optimisations;

//use GGChat\includes\Dbh;

date_default_timezone_set("America/New_York");
$annee = date("Y");
$annee -= 1;

$time = $annee . date("-m-d H:i:s");

//print_r($time);

//include_once '..\includes/dbh.inc.php';
include_once 'dbh.inc.php';

$DbhObject = new Dbh();

$dbh = $DbhObject->getDbh();

$sql_message_group = "SELECT * FROM public.message_groupe WHERE timestamp < '" . $time . "';";

$request_message_group = $dbh->prepare($sql_message_group); 
$request_message_group->execute();
$messages_group = $request_message_group->fetchAll();

if($messages_group[0]['id'])
{
    foreach($messages_group as $message){
        $sql = "INSERT INTO public.message_groupe_archive(groupe_fkey, membre_fkey, message_groupe_contenu, \"timestamp\") VALUES (:groupe_fkey, :membre_fkey, :message_groupe_contenu, :timestamp);";
        
        $request= $dbh->prepare($sql); 
        $request->bindParam(':groupe_fkey', $message['groupe_fkey']);
        $request->bindParam(':membre_fkey', $message['membre_fkey']);
        $request->bindParam(':message_groupe_contenu', $message['message_groupe_contenu']);
        $request->bindParam(':timestamp', $message['timestamp']);
        $success = $request->execute();
        
        if ($success){
            $sql = "DELETE FROM public.message_groupe WHERE id = :id;";
            
            $request = $dbh->prepare($sql); 
            $request->bindParam(':id', $message['id']);
            $request->execute();
            $messages_group = $request->fetchAll();
        }
    }
}

$sql_message_prive = "SELECT * FROM public.message_prive WHERE timestamp < '" . $time . "';";

$request_message_prive = $dbh->prepare($sql_message_prive); 
$request_message_prive->execute();
$messages_prive = $request_message_prive->fetchAll();

if($messages_prive[0]['id'])
{   
    foreach($messages_prive as $message){
        $sql = "INSERT INTO public.message_prive_archive(membre_envoyeur_fkey, membre_receveur_fkey, message_prive_contenu, \"timestamp\") VALUES (:membre_envoyeur_fkey, :membre_receveur_fkey, :message_prive_contenu, :timestamp);";
        
        $request= $dbh->prepare($sql); 
        $request->bindParam(':membre_envoyeur_fkey', $message['membre_envoyeur_fkey']);
        $request->bindParam(':membre_receveur_fkey', $message['membre_receveur_fkey']);
        $request->bindParam(':message_prive_contenu', $message['message_prive_contenu']);
        $request->bindParam(':timestamp', $message['timestamp']);
        $success = $request->execute();
        
        if ($success){
            $sql = "DELETE FROM public.message_prive WHERE id = :id;";
            
            $request = $dbh->prepare($sql); 
            $request->bindParam(':id', $message['id']);
            $request->execute();
        }
    }
}