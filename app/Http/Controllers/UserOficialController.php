<?php

namespace App\Http\Controllers;

use App\Models\UserOficial;
use Illuminate\Http\Request;
use LaravelDoctrine\ORM\Facades\EntityManager;

class UserOficialController extends Controller
{
    public function store()
    {
        $userOficial = new UserOficial();
        $userOficial->setFirstName('Gabriel Victor');

        // EntityManager::persist($userOficial);
        // EntityManager::flush();
    }
}
