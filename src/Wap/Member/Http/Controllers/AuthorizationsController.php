<?php
/**
 * Created by PhpStorm.
 * User: arun
 * Date: 2019/12/3
 * Time: 6:09 PM
 */

namespace ArunFung\Shop\Wap\Member\Http\Controllers;

use ArunFung\Shop\Wap\Member\Support\Facades\Member;
use Illuminate\Http\Request;
use ArunFung\Shop\Wap\Member\Models\User;

class AuthorizationsController extends Controller
{
    public function wechatStore(Request $request)
    {
        // 获取微信的用户信息
        $wechatUser = session('wechat.oauth_user.default');
        $user = User::where("openid", $wechatUser->id)->first();

        if (!$user) {
            // 不存在记录用户信息
            $user = User::create([
                "nickname"      => $wechatUser->nickname,
                "openid" => $wechatUser->id,
                "avatar"    => $wechatUser->avatar,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]);
        }

        Member::guard()->login($user);
        if (Member::guard()->check()) {
            return "通过";
        }
       return "登录失败";
        //return redirect()->route('wap.member.index');
    }
}