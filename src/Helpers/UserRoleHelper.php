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
        $userStateTypeDataResolver = UserStateTypeDataResolverFacade::getInstance();
        $userID = $userStateTypeDataResolver->getCurrentUserID();
        $userRoles = $userRoleTypeDataResolver->getUserRoles($userID);
        return in_array($roleName, $userRoles);
    }

    public static function doesCurrentUserHaveAnyRole(array $roleNames): bool
    {
        // Check if the user has the required role
        $userRoleTypeDataResolver = UserRoleTypeDataResolverFacade::getInstance();
        $userStateTypeDataResolver = UserStateTypeDataResolverFacade::getInstance();
        $userID = $userStateTypeDataResolver->getCurrentUserID();
        $userRoles = $userRoleTypeDataResolver->getUserRoles($userID);
        return !empty(array_intersect($roleNames, $userRoles));
    }

    public static function doesCurrentUserHaveCapability(string $capability): bool
    {
        // Check if the user has the required role
        $userRoleTypeDataResolver = UserRoleTypeDataResolverFacade::getInstance();
        $userStateTypeDataResolver = UserStateTypeDataResolverFacade::getInstance();
        $userID = $userStateTypeDataResolver->getCurrentUserID();
        $userCapabilities = $userRoleTypeDataResolver->getUserCapabilities($userID);
        return in_array($capability, $userCapabilities);
    }

    public static function doesCurrentUserHaveAnyCapability(array $capabilities): bool
    {
        // Check if the user has the required role
        $userRoleTypeDataResolver = UserRoleTypeDataResolverFacade::getInstance();
        $userStateTypeDataResolver = UserStateTypeDataResolverFacade::getInstance();
        $userID = $userStateTypeDataResolver->getCurrentUserID();
        $userCapabilities = $userRoleTypeDataResolver->getUserCapabilities($userID);
        return !empty(array_intersect($capabilities, $userCapabilities));
    }
}
