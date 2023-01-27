<?php

namespace App\Http\Middleware;

use App\Actions\LogoutHandle\DeleteLoggedUserSession;
use App\Actions\LogoutHandle\UpdateLogDatabase;
use App\Crypt\DurationSessionCrypt;
use App\Exceptions\InvalidTokenException;
use App\Handles\LogoutHandle;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UserLoggedAuthenticate
{
    private LogoutHandle $logoutHandle;

    public function __construct(LogoutHandle $logoutHandle)
    {
        $this->logoutHandle = $logoutHandle;    
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!session()->has('logged_user')) {
                return redirect()
                    ->route('login.index')
                    ->with('msgError', 'To access this page you need to login');
            }
    
            $token = session()->get('logged_user_duration');
            $durationSessionCrypt = new DurationSessionCrypt();
            
            $durationSessionCrypt->valid($token);
    
            return $next($request);
        } catch (InvalidTokenException $e) {
            $this->logoutHandle->addActions(new UpdateLogDatabase());
            $this->logoutHandle->addActions(new DeleteLoggedUserSession());
            $this->logoutHandle->execute();

            return redirect()
                ->route('login.index')
                ->with('msgError', $e->getMessage());
        } catch (\Throwable $e) {
            return back()
                ->with('msgError', "Something wrong happened! Contact an administrator");
        }  
    }
}
