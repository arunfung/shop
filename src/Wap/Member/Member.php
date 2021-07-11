<?php
namespace ArunFung\Shop\Wap\Member;

use Illuminate\Support\Facades\Auth;

/**
 * Class Member
 *
 * @see \Illuminate\Contracts\Auth\Guard
 * @see \Illuminate\Contracts\Auth\StatefulGuard
 *
 * @package ArunFung\Shop\Wap\Member
 */
class Member
{
    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    public function guard()
    {
        return Auth::guard(config('wap.member.auth.guard'));
    }
}