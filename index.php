<?php
error_reporting(0);
$tok = <Your Bot Token Here>;//Replace This With Your Bot Token..Get One From @BotFather
function botaction($method, $data){
/*
 * This Function Helps In Making The Code Clean And DRY(Dont Repeat Yourself)😅
 */
	global $tok;
	global $dadel;
	global $dueto;
    $url = "https://api.telegram.org/bot$tok/$method";
    $curld = curl_init();
    curl_setopt($curld, CURLOPT_POST, true);
    curl_setopt($curld, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curld, CURLOPT_URL, $url);
    curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($curld);
    curl_close($curld);
    $dadel = json_decode($output,true);
    $dueto = $dadel['description'];
    return json_decode($output,true);
}
//These Are The Needed Variables!! 😬😬
$update = file_get_contents('php://input');
$update = json_decode($update, true);


$mid = $update['message']['message_id'];
$cid = $update['message']['chat']['id'];
$uid = $update['message']['chat']['id'];
$cname = $update['message']['chat']['username'];
$fid = $update['message']['from']['id'];
$fname = $update['message']['from']['first_name'];
$lname = $update['message']['from']['last_name'];
$uname = $update['message']['from']['username'];
$typ = $update['message']['chat']['type'];
$texts = $update['message']['text'];
$text = strtolower($update['message']['text']);
$fullname = ''.$fname.' '.$lname.'';

##################NEW MEMBER DATA ################
$new_member = $update['message']['new_chat_member'];
$gname = $update['message']['chat']['title'];
$nid = $update['message']['new_chat_member']['id'];
$nfname = $update['message']['new_chat_member']['first_name'];
$nlname = $update['message']['new_chat_member']['last_name'];
$nuname = $update['message']['new_chat_member']['username'];
$nfullname = ''.$nfname.' '.$nlname.'';
#################################################
$lfname = $update['message']['left_chat_member']['first_name'];
$llname = $update['message']['left_chat_member']['last_name'];
$luname = $update['message']['left_chat_member']['username'];
$reply_message = $update['message']['reply_to_message'];
$reply_message_id = $update['message']['reply_to_message']['message_id'];
$reply_message_user_id = $update['message']['reply_to_message']['from']['id'];
$reply_message_text = $update['message']['reply_to_message']['text'];
$reply_message_user_fname = $update['message']['reply_to_message']['from']['first_name'];
$reply_message_user_lname = $update['message']['reply_to_message']['from']['last_name'];
$reply_message_user_uname = $update['message']['reply_to_message']['from']['username'];
#######################################################################################
###########################CALL BACK DATA##############################################
$callback = $update['callback_query'];
$callback_id = $update['callback_query']['id'];
$callback_from_id = $update['callback_query']['from']['id'];
$callback_from_uname = $update['callback_query']['from']['username'];
$callback_from_fname = $update['callback_query']['from']['first_name'];
$callback_from_lname = $update['callback_query']['from']['last_name'];
$callback_user_data = $update['callback_query']['data'];
$callback_message_id = $update['callback_query']['message']['id'];
$cbid = $update['callback_query']['message']['chat']['id'];
$cbmid = $update['callback_query']['message']['message_id'];
$thug_chat_id = '';
$chat_id = (string)$cid;
$sticker = $update['message']['sticker'];
$is_animated = $update['message']['sticker']['is_animated'];
$sticker_id = $update['message']['sticker']['file_id'];

//Bot Coding Starts From Here ✌️✌️
if ($typ == 'private') {//Checking If The Message Is Send In Private Or In Group..If In Group Don't Reply!!
  if ($sticker) {
    $sticker_img = botaction("getFile",['file_id'=>$sticker_id]);//Using The Above Function We Connect To The Telegram Api For More Detailed Information Visit https://core.telegram.org/bots/api
    echo $sticker_path = $sticker_img['result']['file_path'];
    if($is_animated)//Checkig If The Given Sticker Is Animated Or Normal Sticker
    {
      $sed = "https://api.telegram.org/file/bot$tok/$sticker_path";
      file_put_contents("Sticker2Raw.tgs",file_get_contents($sed));
      $filepath = realpath('Sticker2Raw.tgs');
      botaction("sendDocument",['chat_id'=>$cid,'document'=>new CurlFile($filepath),'reply_to_message_id'=>$mid]);
    }
    else
    {
      echo $sed = "https://api.telegram.org/file/bot$tok/$sticker_path";
      file_put_contents("Sticker2Raw.png",file_get_contents($sed));
      $filepath = realpath('Sticker2Raw.png');
      botaction("sendDocument",['chat_id'=>$cid,'document'=>new CurlFile($filepath),'reply_to_message_id'=>$mid]);
      // unlink("sticker.png");
    }
//Sending The Raw Format Of The Sticker And being Quiet Again
  }//End Of Checking Sticker
  else {
    botaction("sendMessage",['chat_id'=>$cid,'text'=>"Hey, $fname. \n<code>I am Sticker2Raw Robot. I Help You To Convert Any Sticker Animated Or Png Sticker To A Raw File!!</code>\n\n<b>Bot Made By : @NoobsGang</b>",'parse_mode'=>'HTML','reply_to_message_id'=>$mid]);
  }//This Will Send The Start Message Everytime If The User Doesnt Send A Sticker

}//End Of Main If..
else{}
