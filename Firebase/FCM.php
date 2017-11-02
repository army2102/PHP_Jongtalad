<?php
class FCM {
    public function send_notification($token, $payload_notification, $payload_data) {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            // 'registration_ids' => $token,
            'condition' => "'logined' in topics && 'lockReserved' in topics",
            // 'to' => '/topics/lockReserved',
            'priority' => 'normal',
            'notification' => $payload_notification,
            'data' => $payload_data
        );

        $headers = array(
            'Authorization: key=AAAA2FpI9ZM:APA91bHUpD_1hQqoacZoAdcqrIGQHhjh6w3aQN1rf31eA8Y1MpAzJN-DyNKx5UVxibQNgkNJwStSttlTtlowGpcroJGp6DRCJtgxsUkJwzgXQDUbmIQLd1pAHWPqcfvrqlaM7UNgGbey',
            'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporary
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        echo $result;
    }
}
?>