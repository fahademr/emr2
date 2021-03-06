<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class RedirectIfAuthenticated
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->check()) {
            if($this->auth->user()->hasRole('super')){
                return redirect('super/dashboard');
            }elseif($this->auth->user()->hasRole('admin')){
                return redirect('admin/dashboard');
            }elseif($this->auth->user()->hasRole('receptionist')){
                return redirect('receptionist/dashboard');
            }elseif($this->auth->user()->hasRole('pharmaceutical')){
                return redirect('pharmaceutical/dashboard');
            }
        }

        return $next($request);
    }
}
