<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class DiscordNotification extends Controller
{
    public function trainingNotification()
    {
        $trening=DB::table('trainees')->where('cid', auth()->user()->cid)->first();
        //<@&572740430676885517>
        return Http::post('https://discord.com/api/webhooks/826503233110802452/YTqcfkd7ZHyLC8SMP0_cEcOyeH-lgIpyUAh-JxBTDLv9Md8kX-JeHNtlUtcUbTfKW93a', [
            //'content' => "New training request <@&572740430676885517>",
            'content' => "",
            'embeds' => [
                [
                    'title' => "ATC Center notification [".Carbon::now()->format('H:i')."z]",
                    'description' => "A new training request has been made",
                    'color' => '14783755',
                    "fields" => [
                        // Field 1
                        [
                            "name" => "Trainee",
                            "value" => substr((auth()->user()->name),0,1).".".substr((auth()->user()->last_name),0,1).". "."[".auth()->user()->cid."]",
                            "inline" => false
                        ],
                        [
                            "name" => "Date and time",
                            "value" => "10.4.2021. 18:00-21:00",
                            "inline" => false
                        ],
                        [
                            "name" => "Positions",
                            "value" => $trening->airports,
                            "inline" => false
                        ]
                    ]
                ]
            ],
        ]);

    }
    public function rosterNotification()
    {
        return Http::post('https://discord.com/api/webhooks/826503233110802452/YTqcfkd7ZHyLC8SMP0_cEcOyeH-lgIpyUAh-JxBTDLv9Md8kX-JeHNtlUtcUbTfKW93a', [
            'content' => "This is test message from VATAdria ATC Center!",
            'embeds' => [
                [
                    'title' => "VATAdria ATC Center Notification!",
                    'description' => "This is test message from VATAdria ATC Center!",
                    'color' => '7506394',
                ]
            ],
        ]);

    }
}
