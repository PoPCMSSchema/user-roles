<?php
namespace PoP\UserRoles\FieldResolvers;

use PoP\Engine\TypeResolvers\RootTypeResolver;
use PoP\UserRoles\FieldResolvers\RolesFieldResolverTrait;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;

class RootRolesFieldResolver extends AbstractDBDataFieldResolver
{
    use RolesFieldResolverTrait;

    public static function getClassesToAttachTo(): array
    {
        return [
            RootTypeResolver::class,
        ];
    }
}
