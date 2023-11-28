<?php

namespace App\Http\Controllers;

use App\Notifications\OrderProcessed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp;

class whatsappMessageController extends Controller
{
    //using twilio
    public function index(Request $request)
    {
        $orders = [
            'id'=> '1',
            'name' => 'jugale',
            'amount' => '80000',
            'created_at'=>'25/05/5324'
        ];
        $request->user()->notify(new OrderProcessed($orders));
        dump('called');
    }
    //using Cloud API
    public function index1(Request $request)
    {

        $text_arr = array(
            'name' => 'inquary_message',
            'language'=>array( 'code'=> 'en_US')
            // 'preview_url' => 'false', 
            // 'body' => 'Hello, this is a test from home'
        );
    
        $fields = array(
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            // 'from'=>'91xxxxxxxxxx', 
            'to' => '918530187408',
            'type' => 'template',
            'template' => json_encode($text_arr)
        );
        $header = array(
            "Authorization: Bearer EAAocJRVnQH4BAGdbDUfuMhnHiKdGs5XzloKjVZBzWrl86uZC2uowZA6diXP82ba4FO8XLWrXywgKnmh47RDPwzq4kHM0cDFP6YvF8R1B13PqssURgDwpuMvqZCCBDLdZCeLFN67hI049IEUoiwoGsV2P50qIOSqj1OoQu0Evqk0eUUUoBnDy7GXeBKgY8blHhny0t4blZAvP4UWS8CUzlt",
            "Content-Type: application/json"
        );
        $phone='+918530187408';
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://graph.facebook.com/v15.0/114705484881599/messages',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>json_encode($fields),
          CURLOPT_HTTPHEADER => $header,
        ));
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $response = json_decode(curl_exec($curl), true);
        
        curl_close($curl);        
        print_r($response);
    }
}
