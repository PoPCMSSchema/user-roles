<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\API\TypeResolvers\RootTypeResolver;
use PoP\API\TypeResolvers\SiteTypeResolver;
use PoP\Users\TypeResolvers\UserTypeResolver;

trait RolesValidateConditionForFieldsTypeResolverDecoratorTrait
{
    public static function getClassesToAttachTo(): array
    {
        return array(
            RootTypeResolver::class,
            SiteTypeResolver::class,
            UserTypeResolver::class,
        );
    }

    protected function getFieldNames(): array
    {
        return [
            'roles',
            'capabilities',
        ];
    }
}
