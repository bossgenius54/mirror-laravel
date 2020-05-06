<?php

namespace App\Policies\Order;

use App\User;
use App\Model\SysUserType;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Model\SysOrderStatus;

use App\Services\Order\CanChangeOrderStatusRules;

class OrderPolicy {
    use HandlesAuthorization;

    public function __construct(){

    }

    public function list($user){
        if (!in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::MANAGER, SysUserType::ADMIN,  SysUserType::ACCOUNTER,  SysUserType::FIZ,  SysUserType::COMPANY_CLIENT]))
            return false;

        return true;
    }

    public function create($user){
        if (!in_array($user->type_id, [SysUserType::MANAGER,  SysUserType::DIRECTOR]))
            return false;

        return true;
    }


    public function createForFiz($user){
        return false;

        if (!in_array($user->type_id, [SysUserType::FIZ]))
            return false;

        return true;
    }

    public function createForCompanyClient($user){
        if (!in_array($user->type_id, [SysUserType::COMPANY_CLIENT]))
            return false;

        return true;
    }

    public function view($user, $item){
        if (in_array($user->type_id, [SysUserType::ADMIN]))
            return true;

        if ($user->type_id == SysUserType::COMPANY_CLIENT){
            if ($user->company_id != $item->from_company_id)
                return false;

            return true;
        }

        if (!in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::MANAGER, SysUserType::ADMIN,  SysUserType::ACCOUNTER, SysUserType::FIZ]))
            return false;

        if ($user->type_id == SysUserType::FIZ && $item->from_user_id != $user->id)
            return false;

        else if ($user->type_id == SysUserType::FIZ)
            return true;

        if ($user->company_id != $item->company_id)
            return false;

        return true;
    }

    public function update($user, $item){
        if (!in_array($user->type_id, [SysUserType::MANAGER, SysUserType::DIRECTOR]))
            return false;

        if ($user->company_id != $item->company_id)
            return false;

        if (!in_array($item->status_id, SysOrderStatus::getCanManagerUpdate()))
            return false;

        if ($item->is_onlain == 1 && $item->status_id == SysOrderStatus::CREATED)
            return false;

        return true;
    }

    public function service($user, $item){
        if (!in_array($user->type_id, [SysUserType::MANAGER, SysUserType::DIRECTOR, SysUserType::FIZ, SysUserType::COMPANY_CLIENT]))
            return false;

        if ($user->type_id == SysUserType::FIZ){
            if ($item->is_onlain != 1)
                return false;

            if ($item->status_id != SysOrderStatus::CREATED)
                return false;

            return true;
        }

        if ($user->type_id == SysUserType::COMPANY_CLIENT){
            if ($item->is_onlain != 1)
                return false;

            if ($user->company_id != $item->from_company_id)
                return false;

            if ($item->status_id != SysOrderStatus::CREATED)
                return false;

            return true;
        }


        if ($item->is_onlain == 1 && $item->status_id == SysOrderStatus::CREATED)
            return false;

        if (!in_array($item->status_id, SysOrderStatus::getCanManagerUpdate()))
            return false;

        return true;
    }

    public function position($user, $item){
        if (!in_array($user->type_id, [SysUserType::MANAGER, SysUserType::DIRECTOR, SysUserType::FIZ, SysUserType::COMPANY_CLIENT]))
            return false;

        if ($user->type_id == SysUserType::FIZ){
            if ($item->is_onlain != 1)
                return false;

            if ($item->status_id != SysOrderStatus::CREATED)
                return false;

            return true;
        }

        if ($user->type_id == SysUserType::COMPANY_CLIENT){
            if ($item->is_onlain != 1)
                return false;

            if ($user->company_id != $item->from_company_id)
                return false;

            if ($item->status_id != SysOrderStatus::CREATED)
                return false;

            return true;
        }

        if ($item->is_onlain == 1 && $item->status_id == SysOrderStatus::CREATED)
            return false;

        if (!in_array($item->status_id, SysOrderStatus::getCanManagerUpdate()))
            return false;

        return true;
    }

    public function status($user, $item, $status){
        $ar_can_change = CanChangeOrderStatusRules::getArStatus($user, $item);


        return in_array($status->id, $ar_can_change);
    }

    public function filterManager($user){
        if (!in_array($user->type_id, [SysUserType::DIRECTOR, SysUserType::ADMIN, SysUserType::ACCOUNTER]))
            return false;

        return true;
    }
}
