<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $menus = Menu::with('roles')
                ->whereHas('roles', function ($query) use ($user) {
                    $query->where('role_id', $user->role_id);
                })
                ->get();
                $menuArray = $menus->pluck('url', 'id')->toArray();
                $segments = explode('/', $request->path());
                $firstSegment = $segments[0];
                if($firstSegment == null){
                    $firstSegment = '/';
                }
                $menu = Menu::where('url', $firstSegment)->first();
                if ($menu->main_menu != '' || $menu->main_menu != null) {
                    if (array_key_exists($menu->main_menu, $menuArray)) {
                        if (in_array($firstSegment, $menuArray)) {
                            return $next($request);
                        }
                    }
                } else {
                if (array_key_exists($menu->id, $menuArray)) {
                    if (in_array($firstSegment, $menuArray)) {
                        return $next($request);
                    }
                }
            }
        }

        abort(403, 'Unauthorized');
    }
}
