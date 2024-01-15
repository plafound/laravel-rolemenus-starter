<?php

use App\Models\LogPertemuan;
use App\Models\Menu;
use App\Models\LogUser;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getMenus')) {
    function getMenus()
    {
        return Menu::with('subMenus')->where('active', 1)->whereNull('main_menu')->get();
        // $user = Auth::user();
        // print_r

        // $menus = Menu::with('roles')
        //     ->whereHas('roles', function ($query) use ($user) {
        //         $query->where('role_id', $user->role_id);
        //     })
        //     ->get();
        // return $menus;
    }
}
if (!function_exists('isMenuAllowed')) {
    function isMenuAllowed($menu)
    {
        // Ambil peran (role) pengguna saat ini
        $userRole = Auth::user();

        // Cek apakah menu memiliki role yang sesuai dengan role pengguna
        return $menu->roles->contains('id', $userRole->role_id);
    }
}
if (!function_exists('addLogUser')) {
    function addLogUser($activity)
    {
        LogUser::create([
            'user_id' => auth()->user()->id,
            'activity' => $activity ?? null,
            'ip_address' => request()->ip(),
        ]);
    }
}

if (!function_exists('addPertemuanLog')) {
    function addPertemuanLog($id)
    {
        LogPertemuan::create([
            'user_id' => auth()->user()->id,
            'pertemuan_id' => $id,
            'ip_address' => request()->ip(),
        ]);
    }
}
