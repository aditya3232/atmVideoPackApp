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

    // ini authorization jgn dihapus
    public function sidebarParentDashboard(User $user)
    {
        return $user->role->hasPermission('sidebar parent dashboard');
    }

    public function sidebarParentSettingAdmin(User $user)
    {
        return $user->role->hasPermission('sidebar parent setting admin');
    }

    public function sidebarParentHelp(User $user)
    {
        return $user->role->hasPermission('sidebar parent help');
    }


    // ini authorization parent, boleh diganti
    public function sidebarParentHumanDetection(User $user)
    {
        return $user->role->hasPermission('sidebar parent human detection');
    }

    public function sidebarParentVandalDetection(User $user)
    {
        return $user->role->hasPermission('sidebar parent vandal detection');
    }

    public function sidebarParentStreamingCctv(User $user)
    {
        return $user->role->hasPermission('sidebar parent streaming cctv');
    }

    public function sidebarParentDownloadPlayback(User $user)
    {
        return $user->role->hasPermission('sidebar parent download playback');
    }

    public function sidebarParentMasterDevice(User $user)
    {
        return $user->role->hasPermission('sidebar parent master device');
    }

    public function sidebarParentMasterLocation(User $user)
    {
        return $user->role->hasPermission('sidebar parent master location');
    }


    // ini authorization child, boleh diganti
    public function sidebarChildSettingAdminPermission(User $user)
    {
        return $user->role->hasPermission('sidebar child permission'); 
    }


}