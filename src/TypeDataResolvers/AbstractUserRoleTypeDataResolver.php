<?php

declare(strict_types=1);

namespace PoPSchema\UserRoles\TypeDataResolvers;

use PoP\Hooks\Facades\HooksAPIFacade;

abstract class AbstractUserRoleTypeDataResolver implements UserRoleTypeDataResolverInterface
{
    public function getTheUserRole(mixed $userObjectOrID): string
    {
        $roles = $this->getUserRoles($userObjectOrID);
        $role = $roles[0];
        // Allow URE to override this function
        return HooksAPIFacade::getInstance()->applyFilters(
            'getTheUserRole',
            $role,
            $userObjectOrID
        );
    }

    public function userCan(mixed $userObjectOrID, string $capability): bool
    {
        $capabilities = $this->getUserCapabilities($userObjectOrID);
        return in_array($capability, $capabilities);
    }

    public function hasRole(mixed $userObjectOrID, string $role): bool
    {
        $roles = $this->getUserRoles($userObjectOrID);
        return in_array($role, $roles);
    }
}
