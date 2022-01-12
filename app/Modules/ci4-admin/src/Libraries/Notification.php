<?php

namespace Adnduweb\Ci4Admin\Libraries;

use Twilio\Rest\Client;

class Notification
{
    // public function sms($to, $title, $message, $img)
    // {

    //     $to = str_replace(' ', '', $to);
    //     $msg = $message;
    //     $content = array(
    //         "fr" => $msg
    //     );
    //     $headings = array(
    //         "fr" => $title
    //     );
    //     if ($img == '') {
    //         $fields = array(
    //             'app_id' => 'cbe63bd5-647e-4e60-bdea-0bbb339d913a',
    //             // "headings" => $headings,
    //             // 'include_player_ids' => array($to),
    //             // 'large_icon' => "https://www.google.co.in/images/branding/googleg/1x/googleg_standard_color_128dp.png",
    //             // 'content_available' => true,
    //             // 'contents' => $content
    //             "name" =>"Identifier for SMS Message",
    //             "sms_from" =>"+15555555555",
    //             "contents" => [ 'fr' =>"Welcome to Cat Facts!" ],
    //             "sms_media_urls" =>["https://cat.com/cat.jpg"],
    //             "include_phone_numbers" =>["+33684635390"]
    //         );
    //     } else {
    //         $ios_img = array(
    //             "id1" => $img
    //         );
    //         $fields = array(
    //             'app_id' => 'cbe63bd5-647e-4e60-bdea-0bbb339d913a',
    //             // "headings" => $headings,
    //             // 'include_player_ids' => array($to),
    //             // 'contents' => $content,
    //             // "big_picture" => $img,
    //             // 'large_icon' => "https://www.google.co.in/images/branding/googleg/1x/googleg_standard_color_128dp.png",
    //             // 'content_available' => true,
    //             // "ios_attachments" => $ios_img
    //             "name" =>"Identifier for SMS Message",
    //             "sms_from" =>"+15555555555",
    //             "contents" => [ 'fr' =>"Welcome to Cat Facts!" ],
    //             "sms_media_urls" =>["https://cat.com/cat.jpg"],
    //             "include_phone_numbers" =>["+33684635390"]
    //         );
    
    //     }
    //     $headers = array(
    //         'Authorization: basic YjExYzFmNDctNGNkMS00MzU4LTgwY2YtMmQ2ZDY0ODc3OGJk',
    //         'Content-Type: application/json; charset=utf-8'
    //     );
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    //     $result = curl_exec($ch);

    //     print_r($result); exit;
    //     curl_close($ch);
    //     return $result;
    // }

    public function sendSms($to, string $message){

        // Your Account SID and Auth Token from twilio.com/console
        $account_sid = config('Notifications')->twilio['account_sid'];
        $auth_token = config('Notifications')->twilio['auth_token'];
        // In production, these should be environment variables. E.g.:
        // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

        // A Twilio number you own with SMS capabilities
        $twilio_number = "+12099924669";

        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            // Where to send a text message (your cell phone?)
            $to,
            array(
                'from' => $twilio_number,
                'body' => $message
            )
        );

        return $client ;

    }

}