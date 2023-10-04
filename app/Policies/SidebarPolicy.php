<?php

namespace App\Policies;

use App\Models\Sidebar;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SidebarPolicy
{

    // jika role admin, maka admin bisa akses semua permissions
    public function before(User $user, $ability) {
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    // ini authorization Parent untuk permission 
    public function sidebarParentDashboard(User $user)
    {
        return $user->role->hasPermission('sidebar parent dashboard'); // ini jgn ditampilkan di tabel biar g dihapus
    }

    public function sidebarParentLogAcceptReject(User $user)
    {
        return $user->role->hasPermission('sidebar parent log accept reject'); 
    }

    public function sidebarParentSettingDoorLock(User $user)
    {
        return $user->role->hasPermission('sidebar parent setting door lock'); 
    }

    public function sidebarParentMasterData(User $user)
    {
        return $user->role->hasPermission('sidebar parent master data'); 
    }

    public function sidebarParentSettingAdmin(User $user)
    {
        return $user->role->hasPermission('sidebar parent setting admin'); 
    }

    public function sidebarParentHelps(User $user)
    {
        return $user->role->hasPermission('sidebar parent helps'); 
    }

    // ini authorization Child untuk permission
    public function sidebarChildSettingAdminPermissions(User $user)
    {
        return $user->role->hasPermission('sidebar permissions'); 
    }


}