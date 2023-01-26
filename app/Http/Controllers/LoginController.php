<?php

namespace App\Http\Controllers;

use App\Actions\LoginHandle\CreateLoggedUserSession;
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
            
            $this->loginHandle->addActions(new CreateLoggedUserSession());
            $this->loginHandle->addActions(new RegisterLogDatabase());
            $this->loginHandle->execute($user);

            return redirect()
                ->route('home.index')
                ->with('msg', "Successfully logged in");
        } catch (ValidationException|PasswordException|NotFoundException $e) { 
            return back()
                ->with('msgError', $e->getMessage());    
        } catch (\Throwable $e) {
            return back()
                ->with('msgError', "Something wrong happened! Contact an administrator");
        }
    }
}
