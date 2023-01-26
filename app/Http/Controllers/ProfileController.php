<?php

namespace App\Http\Controllers;

use App\Crypt\UserCrypt;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;    
    }

    public function index()
    {
        try {
            $titlePage = "Mythology - Profile";

            $crypt = new UserCrypt();
            $user = $crypt->decrypt(session()->get('logged_user'));

            $user = $this->repository->findOneBy(['id' => $user->getId()]);          
            if (is_null($user)) {
                return redirect()
                    ->route('login.index')
                    ->with('msgError', 'User not found. Please contact the administrator for more information.');
            }

            return view('logged.profile.profile', compact(
                'titlePage',
                'user'
            ));
        } catch (\Throwable $e) {
            return back()
                ->with('msgError', "Something wrong happened! Contact an administrator");
        }  
    }
}
