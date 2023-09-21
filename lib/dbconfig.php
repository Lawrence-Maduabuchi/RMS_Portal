<?php
/*$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "";
$DB_name = "sima";

try
{
     $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
     $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
     echo $e->getMessage();
}*/

include_once 'class.user.php';
$user = new USER($con);

include_once 'auth.class.php';
if(isset($_SESSION['user_id']) && isset($menu))
{
    $auth = new authorize($con, $_SESSION['user_id']);

    $authview=$auth->HasView($menu);
    $authupdate=$auth->HasUpdate($menu);
    $authdelete=$auth->HasDelete($menu);
    $authaddnew=$auth->HasAddNew($menu);
    $authorize=$auth->HasAuth($menu);


    $super_authorize = false;
    if($_SESSION['user_session'] == ADMIN_USERNAME)
    {
        $authview=true;
        $authupdate=true;
        $authdelete=true;
        $authaddnew=true;
        $authorize=true;
        
        $super_authorize = true;
    }

}
?>
