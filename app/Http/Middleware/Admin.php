<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
USE App\Models\User;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ログインしているか確認
        if (Auth::check()) {
            // ユーザーが管理者であるか確認
            // if (User::ADMIN_ROLE_ID == 1) {
            if(Auth::user()->role_id == User::ADMIN_ROLE_ID){
                return $next($request);
            }else {
                // ユーザーは管理者ではないので、リダイレクトまたはエラー処理を行う
                return redirect('/')->with('error', 'You do not have administrative privileges.');
            }
        }

        // ログインしていない場合はログインページにリダイレクト
        return redirect('/login');
    }
}
