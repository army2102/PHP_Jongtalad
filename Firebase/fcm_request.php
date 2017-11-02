<?php
include_once 'FCM.php';
/*
$token = array('TOKEN1', 'TOKEN2');
*/
$token = array('');
$notification = array(
	'title' => 'แจ้งเตือนการจอง',
	'body' => 'ถึงเวลาลงขายแล้วจ้า', // Required for iOS
	'sound' => 'default',
	// 'badge' => 1,
	'click_action' => 'OPEN_ACTIVITY_RESERVATION' // เปิด Activity ที่ต้องการ 
);
$data = array(
	// 'picture_url' => 'http://opsbug.com/static/google-io.jpg'
	'picture_url' => 'https://firebasestorage.googleapis.com/v0/b/jongtalad-91591.appspot.com/o/logo.jpg?alt=media&token=28571e38-8081-4a1b-a34e-75139e5b95bb'
	
);
$fcm = new FCM();
$fcm->send_notification($token, $notification, $data);
?>