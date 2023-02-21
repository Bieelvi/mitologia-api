<?php

namespace App\Http\Livewire;

use App\Actions\LoginHandle\{CreateLoggedUserSession, RegisterLogDatabase};
use App\Entities\{Email, User};
use App\Exceptions\{NotFoundException, PasswordException};
use App\Handles\LoginHandle;
use Livewire\Component;

class Login extends Component
{
    private LoginHandle $loginHandle;
    public string $titlePage = 'Login';
    public string $email = '';
    public string $password = '';
    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:2'
    ];

    public function boot(LoginHandle $loginHandle) 
    {
        $this->loginHandle = $loginHandle;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.login')
            ->layoutData(['titlePage' => $this->titlePage]);
    }

    public function login()
    {
        $infosForm = $this->validate();   
        
        try {
            $email = new Email();
            $email->setMain($infosForm['email']);  
    
            $user = new User();
            $user->setEmail($email)
                ->setPassword($infosForm['password']);
                
            $this->loginHandle->addActions(new CreateLoggedUserSession());
            $this->loginHandle->addActions(new RegisterLogDatabase());
            $this->loginHandle->execute($user);

            session()->flash('msg', 'User successfully logged in');  

            $this->reset();

            return redirect()->route('home');
        } catch (PasswordException|NotFoundException $e) { 
            session()->flash('msgError', $e->getMessage());  
        } catch (\Throwable $e) {
            session()->flash('msgError', "Something wrong happened! Contact an administrator"); 
        }        
    }
}
