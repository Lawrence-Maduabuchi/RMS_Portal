<?php
session_start();
include('connection.php');
include('app_config.php');
include('../lib/app_stat.php');
include('../lib/custom.php');

if(isset($_POST['pay']))
{
    switch($_POST['pay'])
    {
        case 'sub':
            $_SESSION['amount'] = $_POST['amount']/100;
            $_SESSION['payment_type'] = $_POST['payment_type'];
            $_SESSION['payment_option'] = $_POST['payment_option'];
            $_SESSION['article_id'] = $_POST['article_id'];
            $end_date =  strtotime('+'.$_POST['duration'].' '.$_POST['span'], strtotime(date('d-m-Y')));
            $_SESSION['end_date'] = date('d-m-Y', $end_date);;
            $callbackurl = APP_URL."download_article?id=".$_POST['article_id'];
            $fullname = GetUserFullName($_SESSION['user_id'], $con);
            paystack($fullname,$_POST['amount'], $_SESSION['user_session'], $callbackurl);
            break;
            
        case 'once':
            $amountkobo = $_POST['amount'] * 100;
            $email = $_POST['email'];
            $_SESSION['giverfullname'] = $_POST['fullname'];
            $_SESSION['giverphone'] = $_POST['phone'];
            $_SESSION['giveremail'] = $_POST['email'];
            $_SESSION['type'] = $_POST['type'];
            $callbackurl = APP_URL."give-success";
            paystack($amountkobo, $email, $callbackurl);
            break;
    }
    
}
?>