<?php
namespace PoP\UserRoles\Helpers;

use PoP\UserRoles\Facades\UserRoleTypeDataResolverFacade;
use PoP\UserState\Facades\UserStateTypeDataResolverFacade;

class UserRoleHelper
{
    public static function doesCurrentUserHaveRole(string $roleName): bool
    {
        // Check if the user has the required role
        $userRoleTypeDataResolver = UserRoleTypeDataResolverFacade::getInstance();
        $userStateTypeDataResolverFacade = UserStateTypeDataResolverFacade::getInstance();
        $userID = $userStateTypeDataResolverFacade->getCurrentUserID();
        $userRoles = $userRoleTypeDataResolver->getUserRoles($userID);
        return in_array($roleName, $userRoles);
    }
}
