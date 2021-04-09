<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Sms {

    private $gateway;

    public function __construct($gateway = 'termii') {
        $this->gateway = $gateway;
    }


    public function send($numbers, $message, $units) {
        switch ($this->gateway) {
            case 'termii':
                return $this->send_termii($numbers, $message, $units);
                break;
        }
    }


    public function prepare($numbers, $message, $units) {
        //split numbers by comma, space or new line to get an array
        $numbers = preg_split('/[,\s\n]+/', $numbers);
        $numbers = array_map('trim', $numbers);

        //get total pages
        $total_pages = ceil(strlen($message) / 160); 

        //ensure user has sufficient balance to send to all the numbers
        $total_numbers = count($numbers);
        $units_req = SMS_RATE * $total_numbers * $total_pages;
        if ($units < $units_req) {
            return [
                'status' => false, 
                'msg' => "Insufficient balance! At least {$units_req} total units required to send {$total_pages} ".inflect($total_pages, 'page')." of SMS to {$total_numbers} ".inflect($total_numbers, 'contact')
            ];
        }
        return [
            'status' => true, 
            'numbers' => $numbers,
            'units_req' => $units_req
        ];
    }


    private function send_termii($numbers, $message, $units) {
        if (ENVIRONMENT == 'production') {
            $token  = 'TLVT5Q7cKV2LtXrrjSOBgo5lvPMB69te1VgEwHTggVF6KauAak8Eftejfd5tVg';
            $from   = 'N-Alert';
            // $from   = 'Eroodyte';
        } else {
            $token  = 'TLD0ow5CGqR7awKprZgUyu5wHbRgTNViplK3j2V1Ey4LNtCapd3i6U3ILHtFTp';
            $from   = 'talert';
        }

        //do we have sufficient balance
        $prep = $this->prepare($numbers, $message, $units);
        if (!$prep['status']) return ['status' => false, 'msg' => $prep['msg']];

        $data = [
            'to' => $prep['numbers'], //array
            'from' => $from,
            'sms'=> $message,
            'type' => 'plain', //voice, plain
            'channel' => 'dnd', //generic, dnd, whatsapp
            'api_key' => $token
        ];
        $post_data = json_encode($data);
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://termii.com/api/sms/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_HTTPHEADER => [
              "Content-Type: application/json"
            ]
        ]);
        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);
        if ($response->code != "ok") {
            return ['status' => false, 'msg' => "Unable to send message. Verify that the number you are sending to is valid and contains country code."];
        }
        return [
            'status' => true, 
            'msg' => "Message sent successfully",
            'bal' => $units - $prep['units_req']
        ];
    }

}