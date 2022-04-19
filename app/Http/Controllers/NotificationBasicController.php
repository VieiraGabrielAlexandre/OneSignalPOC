<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use OneSignal;

class NotificationBasicController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function sendAll()
    {
        $data = [
            'foo' => 'bar'
        ];

        OneSignal::sendNotificationToAll(
            "Mensagem criada pela api",
            "http://localhost/home",
            $data,
            null,
            $schedule = null
        );
    }

    public function send(Request $request)
    {
        $data = [
            'foo' => 'bar'
        ];

        OneSignal::sendNotificationToUser(
            "Corra ! Aproveite esta oferta",
            $request->id,
            "https://www.amazon.com.br/Kamen-Rider-1-Shotaro-Ishinomori/dp/658679921X/ref=sr_1_2?__mk_pt_BR=ÅMÅŽÕÑ&crid=31R1OTSL0X48B&keywords=hq+black+kamen&qid=1650335034&sprefix=hq+black+kamen%2Caps%2C194&sr=8-2",
            $data,
            null,
            $schedule = null
        );
    }

    public function getAllDevices()
    {
        $app_id = env('ONESIGNAL_APP_ID');

        $client = new Client();
        $response = $client->get("https://onesignal.com/api/v1/players?app_id=" . $app_id, [
            'headers' => [
                'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY'),
                "Accept" => "application/json",
            ]
        ]);

        return (json_decode($response->getBody()->getContents()));


    }

    public function getDevice(Request $request)
    {
        $app_id = env('ONESIGNAL_APP_ID');

        $client = new Client();
        $response = $client->get("https://onesignal.com/api/v1/players/" . $request->device_id . "?app_id=" . $app_id, [
            'headers' => [
                'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY'),
                "Accept" => "application/json",
            ]
        ]);

        return (json_decode($response->getBody()->getContents()));
    }

    public function csvExport()
    {
        $app_id = env('ONESIGNAL_APP_ID');

        $client = new Client();

        $response = $client->post("https://onesignal.com/api/v1/players/csv_export?app_id=" . $app_id, [
            'headers' => [
                'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY'),
                "Accept" => "application/json",
            ]
        ]);

        return (json_decode($response->getBody()->getContents()));
    }
}

