<?php
function RandomString($count) {
    /*$randstr = "";
    srand((double) microtime(TRUE) * 1000000);
    //our array add all letters and numbers if you wish
    $chars = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'p',
        'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '1', '2', '3', '4', '5',
        '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
        'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

    for ($rand = 0; $rand <= $length; $rand++) {
        $random = rand(0, count($chars) - 1);
        $randstr .= $chars[$random];
    }
    return $randstr;*/
    $firstrand = rand(0, 9999);
    $firstcharsno = strlen($firstrand);
    $character_set_array = array();
    $character_set_array[] = array('count' => $count-$firstcharsno, 'characters' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz');
    //$character_set_array[] = array('count' => $count, 'characters' => '');
    $temp_array = array();
    foreach ($character_set_array as $character_set) {
        for ($i = 0; $i < $character_set['count']; $i++) {
            $temp_array[] = $character_set['characters'][rand(0, strlen($character_set['characters']) - 1)];
        }
    }
    shuffle($temp_array);
    return $firstrand.implode('', $temp_array);
}

function SendMessage($title, $recipient, $fromname, $body, $con="")
{
    $sent = false;
    $mail = new PHPMailer;
    
    try {
        $mail->SMTPDebug = 1;
        
        $mail->isSMTP();
        $mail->Host = 'jcmrjournal.org';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@jcmrjournal.org';
        $mail->Password = 'SbBUc9ry-WdK';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        
        $mail->From = 'no-reply@jcmrjournal.org';
        $mail->FromName = $fromname;
        $mail->addAddress($recipient, $recipient);
        $mail->AddReplyTo('info@jcmrjournal.org', 'Tishmilli');
        $mail->isHTML(true);
        
        $mail->Subject = $title;
        $mail->Body    = $body;
        $mail->AltBody =  $body;
        if($mail->send()) {
            $sent = true;
        }
        else
        {
            $sent = false;
        }
    }
    catch(phpmailerException $e){
        echo $e->errorMessage();
    }
    return $sent;
}

function SendMessageToQueue($title,$recipeint,$sendername,$body,\database $con)
{
    $sql = "insert into message (title,recipient,sendername,body) values (:title,:rec,:sender,:body)";
    $fields = array(
        ':title'=>$title,
        ':rec'=>$recipeint,
        ':sender'=>$sendername,
        ':body'=>$body
    );
    $con->insert_query($sql,$fields);
}

function paystack($customername,$amountkobo,$email,$callbackurl)
{
    /*$curl = curl_init();
     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      
     curl_setopt_array($curl, array(
     CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_CUSTOMREQUEST => "POST",
     CURLOPT_POSTFIELDS => json_encode([
     'amount'=>$amountkobo,
     'email'=>$email,
     'callback_url'=>$callbackurl
     ]),
     CURLOPT_HTTPHEADER => [
     "authorization: Bearer ".SECRET_KEY,
     "content-type: application/json",
     "cache-control: no-cache"
     ],
     ));
      
     $response = curl_exec($curl);
     $err = curl_error($curl);*/

    $reference = rand(10000, 999999999);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $body = array(
        "email" => $email,
        "amount" => $amountkobo,
        "currency" => 'NGN',
        "callback_url" => $callbackurl,
        "metadata" => array(
            array(
                "display_name" => $customername,
                "variable_name" => $email,
                "value" => $email
            )
        )
    );
    //the amount in kobo. This value is actually NGN 300
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => -1, //Maximum number of redirects
    CURLOPT_TIMEOUT => 0, //Timeout for request
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($body),
    CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer ".SECRET_KEY,
    "Content-Type: application/json",
    ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
     
    if($err){
        // there was an error contacting the Paystack API
        die('Curl returned error: ' . $err);
    }
     
    $tranx = json_decode($response);
    if(!$tranx->status){
        // there was an error from the API
        die('API returned error: ' . $tranx->message);
    }
     
    // store transaction reference so we can query in case user never comes back
    // perhaps due to network issue
    //save_last_transaction_reference($tranx->data->reference);
     
    // redirect to page so User can pay
    //header('Location: ' . $tranx->data->authorization_url);
    echo '<script>window.location="'.$tranx->data->authorization_url.'"</script>';
}
?>