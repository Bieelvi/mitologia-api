<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Exceptions\PasswordException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use LaravelDoctrine\ORM\Facades\EntityManager;

class UserController extends Controller
{
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
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());            
            $user->checkSamePassword();

            EntityManager::persist($user);
            EntityManager::flush();

            $message = "User created with success!";                        
            return back()->with('msg', $message);
        } catch (PasswordException $e) {  
            return back()->with('msgError', $e->getMessage());
        } catch (ValidationException $e) {  
            return back()->with('msgError', $e->getMessage());
        } catch (\Throwable $e) {
            $message = "Something wrong happened! Contact an administrator";
            return back()->with('msgError', $message);
        }        
    }
}
