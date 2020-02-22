<?php
namespace PoP\UserRoles\FieldResolvers;

use PoP\API\TypeResolvers\RootTypeResolver;
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
