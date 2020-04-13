<?php

declare(strict_types=1);

namespace PoP\UserRoles\Facades;

use PoP\UserRoles\TypeDataResolvers\UserRoleTypeDataResolverInterface;
use PoP\Root\Container\ContainerBuilderFactory;

class UserRoleTypeDataResolverFacade
{
    public static function getInstance(): UserRoleTypeDataResolverInterface
    {
        return ContainerBuilderFactory::getInstance()->get('user_role_type_data_resolver');
    }
}
