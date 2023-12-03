<?php

//discord posting
$msg = ["content" => "login failed"];
$discordURL = 'https://discord.com/api/webhooks/1173034151683837962/Z0IBBo381LVHnhtggorbBjOOnOisbSvVX3_TRFP95fA0RTjeAQEyXKDtoZ9tT7ZnFaeE';


$headers = array('Content-Type: application/json');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $discordURL);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode( $msg ) );
$responses = curl_exec($ch);
curl_close($ch);

?>
