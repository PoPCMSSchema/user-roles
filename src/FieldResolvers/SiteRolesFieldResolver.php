<?php
namespace PoP\UserRoles\FieldResolvers;

use PoP\API\TypeResolvers\SiteTypeResolver;
use PoP\Engine\FieldResolvers\SiteFieldResolverTrait;
use PoP\UserRoles\FieldResolvers\RolesFieldResolverTrait;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;

class SiteRolesFieldResolver extends AbstractDBDataFieldResolver
{
    use RolesFieldResolverTrait, SiteFieldResolverTrait;

    public static function getClassesToAttachTo(): array
    {
        return [
            SiteTypeResolver::class,
        ];
    }
}
