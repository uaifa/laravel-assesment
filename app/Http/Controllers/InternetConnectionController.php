<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class InternetConnectionController extends Controller
{
    public function check()
    {
        $client = new Client();

        try {
            $response = $client->get('https://www.google.com');
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                return 'Internet is connected.';
            } else {
                return 'Internet is not connected.';
            }
        } catch (Exception $e) {
            return 'Internet is not connected.';
        }
    }
}
