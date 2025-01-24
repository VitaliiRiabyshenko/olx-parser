<?php

namespace App\Http\Controllers;

use App\Contracts\Parser;

class HomeController extends Controller
{
    private $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function __invoke()
    {
        $this->parser->parser();
    }
}