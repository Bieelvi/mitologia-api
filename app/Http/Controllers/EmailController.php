<?php

namespace App\Http\Controllers;

use App\Actions\LoginHandle\CreateLoggedUserSession;
use App\Actions\LoginHandle\RegisterLogDatabase;
use App\Crypt\EmailCrypt;
use App\Crypt\UserCrypt;
use App\Exceptions\InvalidTokenException;
use App\Exceptions\NotFoundException;
use App\Exceptions\PasswordException;
use App\Handles\LoginHandle;
use App\Handles\LogoutHandle;
use App\Mail\VerifiedMail;
use App\Repositories\EmailRepository;
use App\Repositories\UserRepository;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use LaravelDoctrine\ORM\Facades\EntityManager;

class EmailController extends Controller
{   
    private LoginHandle $loginHandle;
    private UserRepository $repository;
    private EmailRepository $emailRepository;
    private EmailCrypt $emailCrypt;

    public function __construct(
        LoginHandle $loginHandle, 
        UserRepository $repository, 
        EmailRepository $emailRepository, 
        EmailCrypt $emailCrypt
    ) {
        $this->loginHandle = $loginHandle;     
        $this->repository = $repository;    
        $this->emailRepository = $emailRepository;    
        $this->emailCrypt = $emailCrypt;    
    }

    public function update(int $id, Request $request)
    {
        try {
            $infosForm = $request->validate([
                'email' => 'required|max:100',
                'password' => 'required|max:75',
            ]);

            $email = $this->emailRepository->findOneBy(['main' => $infosForm['email']]);
            if (!is_null($email)) {
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

            $user->setUpdatedAt(new \DateTime())
                ->setPassword($infosForm['password'])
                ->getEmail()->setMain($infosForm['email']);
                
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
            dd($e);
            return back()
                ->with('msgError', "Something wrong happened! Contact an administrator");
        }        
    }

    public function send(int $id, Request $request)
    {
        try {
            $user = $this->repository->findOneBy(['id' => $id]);
            if (is_null($user)) {
                return redirect()
                    ->route('login.index')
                    ->with('msgError', 'User not found. Please contact the administrator for more information.');
            }

            $hashVerified = $this->emailCrypt->encrypt($user);

            $user->getEmail()->setHashVerified($hashVerified);

            $link = url("/user/$id/verified/email?token=$hashVerified");
            $mail = new VerifiedMail($user, $link);
            $mail->envelope();

            Mail::to($user->getEmail()->getMain())
                ->send($mail);

            EntityManager::flush();

            return back()
                ->with('msg', "Email sent");
        } catch (\Throwable $e) {
            return back()
                ->with('msgError', "Something wrong happened! Contact an administrator");
        }          
    }

    public function verified(Request $request)
    {
        try {
            $token = $request->get('token');
            $user = $this->emailCrypt->valid($token);            

            if (is_null($user->getEmail()->getHashVerified())) {
                return redirect()
                    ->route('profile.index')
                    ->with('msg', 'Email already verified');
            }

            $user->getEmail()
                ->setVerified(true)
                ->setVerifiedAt(new \DateTime())
                ->setHashVerified(null);

            EntityManager::flush();

            return redirect()
                ->route('profile.index')
                ->with('msg', 'Email verified successfully!');
        } catch (InvalidTokenException $e) {
            return redirect()
                ->route('home.index')
                ->with('msgError', $e->getMessage());
        } catch (\Throwable $e) {
            return back()
                ->with('msgError', "Something wrong happened! Contact an administrator");
        }     
    }
}
