<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class TwilioController extends Controller
{
    public function sendSms()
    {
        $account_sid = env('TWILIO_ACCOUNT_SID');
        $auth_token = env('TWILIO_AUTH_TOKEN');
        $twilio_number = "+12569801067"; // Your Twilio phone number

        $client = new Client($account_sid, $auth_token);
         try {
          $client->messages->create(
              '+12569801067', // Recipient's phone number
              array(
                  'from' => $twilio_number,
                  'body' => 'I sent this message in under 10 minutes!'
              )
          );
        } catch (\Exception $e) {
        // Handle exceptions or errors
        return "Error: " . $e->getMessage();
    }
        return "SMS sent successfully!";
    }
}
