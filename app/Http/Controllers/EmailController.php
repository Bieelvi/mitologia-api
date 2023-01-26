<?php

namespace App\Http\Controllers;

use App\Actions\LoginHandle\CreateLoggedUserSession;
use App\Actions\LoginHandle\RegisterLogDatabase;
use App\Exceptions\NotFoundException;
use App\Exceptions\PasswordException;
use App\Handles\LoginHandle;
use App\Handles\LogoutHandle;
use App\Repositories\UserRepository;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use LaravelDoctrine\ORM\Facades\EntityManager;

class EmailController extends Controller
{   
    private LoginHandle $loginHandle;
    private UserRepository $repository;

    public function __construct(LoginHandle $loginHandle, UserRepository $repository)
    {
        $this->loginHandle = $loginHandle;     
        $this->repository = $repository;    
    }

    public function update(int $id, Request $request)
    {
        try {
            $infosForm = $request->validate([
                'email' => 'required|max:100',
                'password' => 'required|max:75',
            ]);

            $user = $this->repository->findOneBy(['email' => $infosForm['email']]);
            if (!is_null($user)) {
                return back()
                    ->with('msgError', 'A user already exists for this email. Please choose another');
            } 
    
            $user = $this->repository->findOneBy(['id' => $id]);
            if (is_null($user)) {
                return redirect()
                    ->route('login.index')
                    ->with('msgError', 'User not found. Please contact the administrator for more information.');
            }            
            
            $user->verifiyPassword($infosForm['password']);

            $user->setEmail($infosForm['email'])
                ->setPassword($infosForm['password'])
                ->setUpdatedAt(new \DateTime());
                
            EntityManager::flush();    

            $this->loginHandle->addActions(new CreateLoggedUserSession());
            $this->loginHandle->addActions(new RegisterLogDatabase());
            $this->loginHandle->execute($user);
                
            return redirect()
                ->route('profile.index')
                ->with('msg', "Email successfully updated");
        } catch (ValidationException|PasswordException|NotFoundException $e) { 
            return back()
                ->with('msgError', $e->getMessage());    
        } catch (\Throwable $e) {
            return back()
                ->with('msgError', "Something wrong happened! Contact an administrator");
        }        
    }
}
