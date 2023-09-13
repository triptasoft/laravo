<?php

namespace Triptasoft\Laravo;

use Illuminate\Support\Arr;

class Laravo
{
    public function view($name)
    {
        return view($name);
    }

    public function routes()
    {
        require __DIR__.'/../routes/laravo.php';
    }
}
