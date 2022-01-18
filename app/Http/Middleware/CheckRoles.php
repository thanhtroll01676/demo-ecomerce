<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role1, $role2)
    {
        // Lấy mảng tham số đầu vào
        $argsArr = func_get_args();
        // Bỏ 2 thằng đầu tiên trong mảng
        unset($argsArr[0], $argsArr[1]);
        // Reset lại key của mảng
        $argsArr = array_values($argsArr);
        // Kiểm tra người đã đăng nhập (trong group admin có auth) có role gì?
        if(auth()->user()->hasRole($argsArr)){
            return $next($request);
        }
        // Ai đăng nhập rồi mà ko có role {admin or writer} thì quăng ra tr chủ
        return redirect()->route('frontend.home.index');
    }
}
