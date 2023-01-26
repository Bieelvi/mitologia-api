<?php

namespace App\Http\Controllers;

use App\Actions\LogoutHandle\DeleteLoggedUserSession;
use App\Actions\LogoutHandle\UpdateLogDatabase;
use App\Handles\LogoutHandle;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    private LogoutHandle $logoutHandle;

    public function __construct(LogoutHandle $logoutHandle)
    {
        $this->logoutHandle = $logoutHandle;
    }

    public function logout()
    {
        try {
            $this->logoutHandle->addActions(new UpdateLogDatabase());
            $this->logoutHandle->addActions(new DeleteLoggedUserSession());
            $this->logoutHandle->execute();
    
            return redirect()
                ->route('login.index')
                ->with('msg', 'Logout user');
        } catch (\Throwable $e) {
            return back()
                ->with('msgError', "Something wrong happened! Contact an administrator");
        }  
    }
}
