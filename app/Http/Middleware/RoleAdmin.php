<?php

namespace App\Http\Middleware;

use App\Crypt\UserCrypt;
use App\Repositories\UserRepository;
use Closure;
use Illuminate\Http\Request;

class RoleAdmin
{
    private UserRepository $repository;
    private UserCrypt $userCrypt;

    public function __construct(UserRepository $repository, UserCrypt $userCrypt)
    {
        $this->repository = $repository;
        $this->userCrypt = $userCrypt;
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
        $token = session()->get('logged_user');
        $userToken = $this->userCrypt->decrypt($token);
        $user = $this->repository->findOneBy(['id' => $userToken->getId()]);
        $admin = $user->getRole()->getName() == 'administrator';
        if (!$admin) {
            return redirect()
                ->route('home.index')
                ->with('msgError', 'You cannot access this page');
        }
    
        return $next($request);
    }
}
