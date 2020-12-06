<?php
namespace GGChat\classe\view;

use GGChat\classe\Page;
use GGChat\includes\Dbh;
use PDO;

class Signup extends Page
{
  
  public $title;

  public function __construct() // Constructeur demandant 2 paramètres
  {
      parent::__construct();

      $this->title= 'signUp';

  }
    public function signCheck()
    {
        
        if (isset( $_POST['f_id']))
        {
            

            $firstpg = pg_escape_string($_REQUEST['first']);
            $lastpg = pg_escape_string($_REQUEST['last']);
            $emailpg = pg_escape_string($_REQUEST['email']);
            $uidpg = pg_escape_string($_REQUEST['uid']);
            $pwdpg = pg_escape_string($_REQUEST['pwd']);




            $first = htmlspecialchars($firstpg);
            $last = htmlspecialchars($lastpg);
            $email = htmlspecialchars($emailpg);
            $uid = htmlspecialchars($uidpg);
            $pwd = htmlspecialchars($pwdpg);





            //error handler 
            //check empty fields 


            if (false)//strpos($uid, '<') !== false||strpos($a, '>') !== false
            {
                header("location: ../signUp.php?signUp=NoInjectionXd");

                    exit();

            }
            else
            {


                if (empty($first) || empty($last) ||empty($email) ||empty($uid) ||empty($pwd))
                {

                    //echo "<script>alert('empty')/script>";
                    header("location: signup.php?signUp=empty");

                    exit(); 
                }

                else//valid character check
                {
                    if (preg_match("/^[a-zA-Z0-9]+$/",$first == 1)||preg_match("/^[a-zA-Z0-9]+$/",$last == 1 ))
                    {
                       header("location: signup.php?signUp=noSpecialCaractere");
                        exit();  
                    }
                    else
                    {
                        if (!filter_var($email,FILTER_VALIDATE_EMAIL))
                        {
                            header("location: signup.php?signup=email");
                            exit(); 
                        }
                        else
                        {

                            $DbhObject = new Dbh();

                            $dbh = $DbhObject->getDbh();
                            $sql = $dbh->prepare("SELECT * FROM membre WHERE membre_uid=:uid");
                            $sql->bindParam(':uid', $uid);
                            $sql->execute();
                            $data = $sql->fetchAll();
                            $rows = count($data);


                            if ($rows>0 )
                            {
                                header("location: signup.php?signup=UserUtiliser");
                                exit(); 


                            }
                            else
                            {
                                //hasshing
                                $hashedPwd = password_hash($pwd,PASSWORD_DEFAULT);


                                $sql= $dbh->prepare("INSERT INTO membre 
                                ( membre_first,membre_last,membre_email,membre_uid,membre_pwd) 
                                VALUES (:first,:last,:email,:uid,:hashedPwd)");
                                $sql->bindParam(':first', $first);
                                $sql->bindParam(':last', $last);
                                $sql->bindParam(':email', $email);
                                $sql->bindParam(':uid', $uid);
                                $sql->bindParam(':hashedPwd', $hashedPwd);

                                $sql->execute();

                                header("location: signup.php?signup=Sucsess");
                                exit(); 
                            }  

                        }

                    }
                }
            }

        }
        
        
        
        
        
        
    }
    public function signUpHtml()
    {
        $this->doc .= '<form class="signUp" action="signup.php" method="POST" >
            <input type="text" name="first" placeholder="Firstname">
            <input type="text" name="last" placeholder="Lastname">
            <input type="text" name="email" placeholder="E-mail">
            <input type="text" name="uid" placeholder="Username">
            <input type="password" name="pwd" placeholder="password">
            <button type="submit" name="submit">Sign up</button>
            <input name= "f_id" type="hidden" value="signup">
            </form>';
        
    }


}