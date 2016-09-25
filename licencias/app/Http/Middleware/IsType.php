<?php
namespace CityBoard\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

abstract class IsType
{
    /**
     * @var Guard
     */
    private $auth;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    abstract public function getType();

    public function handle($request, Closure $next)
    {
        if(! $this->auth->user()->is($this->getType())){
            return redirect()->to('home');
        }
        return $next($request);
    }
}