<?php

namespace App\Http\Controllers;

use App\Actions\LoginHandle\CreateLoggedUserSession;
use App\Actions\LoginHandle\RegisterLogDatabase;
use App\Entities\Email;
use App\Entities\User;
use App\Exceptions\NotFoundException;
use App\Exceptions\PasswordException;
use App\Factories\UserFactory;
use App\Handles\LoginHandle;
use App\Repositories\EmailRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use LaravelDoctrine\ORM\Facades\EntityManager;

class LoginController extends Controller
{
    private LoginHandle $loginHandle;
    private EmailRepository $emailRepository;
    private UserFactory $userFactory;

    public function __construct(
        LoginHandle $loginHandle, 
        EmailRepository $emailRepository,
        UserFactory $userFactory
    ) {
        $this->loginHandle = $loginHandle;
        $this->emailRepository = $emailRepository;
        $this->userFactory = $userFactory;
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

            $email = new Email();
            $email->setMain($infosForm['email']);  

            $user = new User();
            $user->setEmail($email)
                ->setPassword($infosForm['password']);
            
            $this->loginHandle->addActions(new CreateLoggedUserSession());
            $this->loginHandle->addActions(new RegisterLogDatabase());
            $this->loginHandle->execute($user);
  
            return response()
                ->redirectToRoute('home.index')
                ->with('msg', "User successfully logged in");
        } catch (ValidationException|PasswordException|NotFoundException $e) { 
            return back()
                ->with('msgError', $e->getMessage());    
        } catch (\Throwable $e) {
            return back()
                ->with('msgError', "Something wrong happened! Contact an administrator");
        }
    }

    public function loginSocialite(string $provider) 
    {
        try {
            $userSocialite = Socialite::driver($provider)->user();

            $user = $this->userFactory->factory([
                'nickname' => $userSocialite->nickname,
                'email' => $userSocialite->email,
                'url_avatar' => $userSocialite->avatar,
                $provider => $userSocialite->token
            ]);
         
            $email = $this->emailRepository->findOneBy(['main' => $userSocialite->email]);
            if (!is_null($email)) {

                $email->setMain($user->getEmail()->getMain())
                    ->getUser()
                    ->setUrlAvatar($user->getUrlAvatar())
                    ->setNickname($user->getNickname())
                    ->setHashGithub($user->getHashGithub())
                    ->setHashFacebook($user->getHashFacebook())
                    ->setHashGmail($user->getHashGmail());

                EntityManager::flush();

                $this->loginHandle->addActions(new CreateLoggedUserSession());
                $this->loginHandle->addActions(new RegisterLogDatabase());
                $this->loginHandle->execute($user);

                return response()
                    ->redirectToRoute('home.index')
                    ->with('msg', "User successfully logged in with {$provider}");
            } else {
                EntityManager::persist($user);
                EntityManager::flush();
    
                $this->loginHandle->addActions(new CreateLoggedUserSession());
                $this->loginHandle->addActions(new RegisterLogDatabase());
                $this->loginHandle->execute($user);
        
                return response()
                    ->redirectToRoute('home.index')
                    ->with('msg', "User successfully created with {$provider}");
            }   
        } catch (\Throwable $e) {
            return response()
                ->redirectToRoute('login.index')
                ->with('msgError', "Something happened when trying to login with {$provider}");
        }
    }
}
