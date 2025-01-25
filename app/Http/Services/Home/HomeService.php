<?php

namespace App\Http\Services\Home;

use App\Models\User;
use App\Contracts\Parser;
use App\Models\Announcement;

class HomeService
{
    private $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function store($data)
    {
        $user = User::firstOrCreate(['email' => $data['email']]);

        auth()->login($user);

        $price = $this->parser->parser($data['url']);

        if ($price) {
            $announcement = Announcement::firstOrCreate(
                ['url' =>  $data['url']],
                ['price' => $price ?? 0]
            );
    
            if (!$user->announcements()->where('id', $announcement->id)->exists()) {
                $user->announcements()->attach($announcement->id);
            }
        }

        return $user;
    }
}