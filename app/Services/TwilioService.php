<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $client;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $this->client = new Client($sid, $token);

        // Set curl options to use custom CA certificate
        $this->client->setHttpClient(new \Twilio\Http\CurlClient(array(
            CURLOPT_CAINFO => base_path('storage/certs/cacert.pem')
        )));
    }

    public function sendSms($to, $message)
    {
        $from = config('services.twilio.from');
        $this->client->messages->create($to, [
            'from' => $from,
            'body' => $message
        ]);
    }
}
