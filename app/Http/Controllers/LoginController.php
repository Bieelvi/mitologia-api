<?php

namespace App\Http\Controllers;

use App\Actions\LoginHandle\RegisterLogDatabase;
use App\Entities\User;
use App\Exceptions\NotFoundException;
use App\Exceptions\PasswordException;
use App\Handles\LoginHandle;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    private LoginHandle $loginHandle;

    public function __construct(LoginHandle $loginHandle)
    {
        $this->loginHandle = $loginHandle;
    }

    public function index()
    {
        return view('login.user');
    }

    public function login(Request $request)
    {
        try {
            $infosForm = $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);
            
            $user = new User();
            $user->setEmail($infosForm['email'])
                ->setPassword($infosForm['password']);
            
            $this->loginHandle->addActions(new RegisterLogDatabase());
            $this->loginHandle->execute($user);

        } catch (ValidationException|PasswordException|NotFoundException $e) { 
            return back()->with('msgError', $e->getMessage());    
        } catch (\Throwable $e) {
            $message = "Something wrong happened! Contact an administrator";
            return back()->with('msgError', $message);
        }
    }
}
