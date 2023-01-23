<?php

namespace App\Http\Controllers;

use App\Actions\LoginHandle\RegisterLogDatabase;
use App\Entities\User;
use App\Exceptions\PasswordException;
use App\Handles\LoginHandle;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use LaravelDoctrine\ORM\Facades\EntityManager;

class UserController extends Controller
{
    private LoginHandle $loginHandle;

    public function __construct(LoginHandle $loginHandle)
    {
        $this->loginHandle = $loginHandle;
    }

    public function index() 
    {
        $titlePage = 'Mitology - Register';

        return view('register.user', compact(
            'titlePage'
        ));
    }

    public function store(Request $request)
    {
        try {
            $infosForm = $request->validate([
                'nickname' => 'required|max:25',
                'email' => 'required|max:100',
                'password' => 'required|max:75',
                'repeatPassword' => 'required|max:75'
            ]);

            $user = new User();
            $user->setNickname($infosForm['nickname'])
                ->setEmail($infosForm['email'])
                ->setPassword($infosForm['password'])
                ->setRepeatPassword($infosForm['repeatPassword'])
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime());
            $user->hashPassword();            
            $user->checkSamePassword();

            EntityManager::persist($user);
            EntityManager::flush();

            $this->loginHandle->addActions(new RegisterLogDatabase());
            $this->loginHandle->execute($user);

            $message = "User successfully created";             
            return response()->redirectToRoute('home.index')->with('msg', $message);
        } catch (PasswordException|ValidationException $e) {  
            return back()->with('msgError', $e->getMessage());
        } catch (\Throwable $e) {
            $message = "Something wrong happened! Contact an administrator";
            return back()->with('msgError', $message);
        }        
    }
}
