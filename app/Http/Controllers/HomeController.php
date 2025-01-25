<?php

namespace App\Http\Controllers;

use App\Http\Services\Home\HomeService;
use App\Http\Requests\UserParserRequest;

class HomeController extends Controller
{
    private $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index()
    {
        return view('home');
    }

    public function store(UserParserRequest $request)
    {
        $data = $request->validated();

        $user = $this->homeService->store($data);

        if (!$user->email_verified_at) {
            return redirect()->route('verify-email-index');
        } else {
            return view('home');
        }
    }
}