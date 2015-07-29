<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 7/28/15
 * Time: 10:16 AM
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Avalon\Entities\User;
use Avalon\Github\Client;
use Illuminate\Contracts\Auth\Guard;
use Laravel\Socialite\Facades\Socialite;
use Avalon\Redis\Client as Redis;

class GithubAuthController extends Controller
{
    /**
     * @var Client
     */
    private $github;

    /**
     * @var Guard
     */
    private $auth;

    /**
     * @var Redis
     */
    private $redis;

    /**
     * @param Guard $auth
     * @param Client $github
     * @param Redis $redis
     */
    public function __construct(Guard $auth, Client $github, Redis $redis)
    {
        $this->github = $github;
        $this->auth = $auth;
        $this->redis = $redis;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login()
    {
        if($this->auth->check()) {
            return redirect('/');
        }

        return Socialite::driver('github')->scopes(['user', 'read:org'])->redirect();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function callback()
    {
        if($this->auth->check()) {
            return redirect('/');
        }

        /** @var \Laravel\Socialite\Two\User $socialUser */
        $socialUser = Socialite::driver('github')->user();
        if(! $socialUser) {
            throw new \Exception("Something went wrong getting the user from github");
        }

        $userMap = [
            'username' => $socialUser->getNickname(),
            'email' => $socialUser->getEmail(),
            'name' => $socialUser->getName(),
            'avatar' => $socialUser->getAvatar(),
            'token' => $socialUser->token,
        ];

        $this->redis->upsertUser($userMap);

        $user = User::make($userMap);
        $this->auth->login($user);

        return redirect('/');
    }
}