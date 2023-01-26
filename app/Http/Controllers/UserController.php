<?php

namespace App\Http\Controllers;

use App\Actions\LoginHandle\CreateLoggedUserSession;
use App\Actions\LoginHandle\RegisterLogDatabase;
use App\Entities\Email;
use App\Entities\User;
use App\Exceptions\PasswordException;
use App\Handles\LoginHandle;
use App\Repositories\EmailRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use LaravelDoctrine\ORM\Facades\EntityManager;

class UserController extends Controller
{
    private LoginHandle $loginHandle;
    private UserRepository $repository;
    private EmailRepository $emailRepository;

    public function __construct(LoginHandle $loginHandle, UserRepository $repository, EmailRepository $emailRepository)
    {
        $this->loginHandle = $loginHandle;
        $this->repository = $repository;
        $this->emailRepository = $emailRepository;
    }

    public function index() 
    {
        $titlePage = 'Mythology - Register';

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

            $email = $this->emailRepository->findOneBy(['main' => $infosForm['email']]);
            if (!is_null($email)) {
                return back()
                    ->with('msgError', 'A user already exists for this email. Please choose another');
            } 

            $email = new Email();
            $email->setMain($infosForm['email']);

            $user = new User();
            $user->setNickname($infosForm['nickname'])
                ->setEmail($email)
                ->setPassword($infosForm['password'])
                ->setRepeatPassword($infosForm['repeatPassword'])
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime());
            $user->hashPassword();            
            $user->checkSamePassword();

            $email->setUser($user);

            EntityManager::persist($user);
            EntityManager::flush();

            $this->loginHandle->addActions(new CreateLoggedUserSession());
            $this->loginHandle->addActions(new RegisterLogDatabase());
            $this->loginHandle->execute($user);
  
            return response()
                ->redirectToRoute('home.index')
                ->with('msg', "User successfully created");
        } catch (PasswordException|ValidationException $e) {  
            return back()->with('msgError', $e->getMessage());
        } catch (\Throwable $e) {
            return back()
                ->with('msgError', "Something wrong happened! Contact an administrator");
        }        
    }

    public function update(int $id, Request $request)
    {
        try {
            $infosForm = $request->validate([
                'nickname' => 'required|max:25'
            ]);
    
            $user = $this->repository->findOneBy(['id' => $id]);
            if (is_null($user)) {
                return redirect()
                    ->route('login.index')
                    ->with('msgError', 'User not found. Please contact the administrator for more information.');
            }
    
            $user->setNickname($infosForm['nickname'])
                ->setUpdatedAt(new \DateTime());
    
            EntityManager::flush();
    
            return redirect()
                ->route('profile.index')
                ->with('msg', "User successfully updated");
        } catch (\Throwable $e) {
            return back()
                ->with('msgError', "Something wrong happened! Contact an administrator");
        }  
    }
}
