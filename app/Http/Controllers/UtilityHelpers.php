<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use DB;

trait UtilityHelpers
{
    private function generateMessageID() {
        return date('YmdHis') . sprintf('%03d', mt_rand(0, 999)) . sprintf('%03d', mt_rand(0, 999)) . sprintf('%03d', mt_rand(0, 999)) . sprintf('%03d', mt_rand(0, 999)) . sprintf('%03d', mt_rand(0, 999)) . sprintf('%03d', mt_rand(0, 999));
    }

    public function send($mobile_number, $message) {
        $message_id = $this->generateMessageID();
        $response = null;

        $client = new Client([
            'redirect.disable' => true
        ]);

        try {
            $http = $client->request('POST', 'https://post.chikka.com/smsapi/request', [
                'form_params' => [
                    'message_type' => 'SEND',
                    'mobile_number' => $mobile_number,
                    'shortcode' => env('CHIKKA_ACCESS_CODE'),
                    'message_id' => $message_id,
                    'message' => $message,
                    'client_id' => env('CHIKKA_CLIENT_ID'),
                    'secret_key' => env('CHIKKA_SECRET_KEY')
                ]
            ]);

            if($http->getStatusCode() === 200) {
                $response = [
                    'status' => 'Success',
                    'message' => 'Message sent.'
                ];
            } else {
                $response = [
                    'status' => 'Failed',
                    'message' => 'Message sending failed.'
                ];
            }
        } catch(RequestException $ex) {
            $response = [
                'status' => 'Failed',
                'message' => 'Message sending failed. Catched Exception: RequestException.'
            ];
        }

        return $response;
    }

    public function reply($request_id, $mobile_number, $message) {
        $message_id = $this->generateMessageID();
        $response = null;

        $client = new Client([
            'redirect.disable' => true
        ]);

        try {
            $http = $client->request('POST', 'https://post.chikka.com/smsapi/request', [
                'form_params' => [
                    'message_type' => 'REPLY',
                    'mobile_number' => $mobile_number,
                    'shortcode' => env('CHIKKA_ACCESS_CODE'),
                    'request_id' => $request_id,
                    'message_id' => $message_id,
                    'message' => $message,
                    'request_cost' => strtoupper(env('CHIKKA_REQUEST_COST')),
                    'client_id' => env('CHIKKA_CLIENT_ID'),
                    'secret_key' => env('CHIKKA_SECRET_KEY')
                ]
            ]);

            if($http->getStatusCode() === 200) {
                $response = [
                    'status' => 'Success',
                    'message' => 'Message sent.'
                ];
            } else {
                $response = [
                    'status' => 'Failed',
                    'message' => 'Message sending failed.'
                ];
            }
        } catch(RequestException $ex) {
            $response = [
                'status' => 'Failed',
                'message' => 'Message sending failed. Catched Exception: RequestException.'
            ];
        }

        return $response;
    }

    public function setFlash($status, $message)
    {
        session()->flash('flash_status', $status);
        session()->flash('flash_message', $message);
    }

    public function generateCode($text) {
        $salt = substr(md5($text), mt_rand(0, 27), 5);

        return sha1($salt . $text);
    }
}
