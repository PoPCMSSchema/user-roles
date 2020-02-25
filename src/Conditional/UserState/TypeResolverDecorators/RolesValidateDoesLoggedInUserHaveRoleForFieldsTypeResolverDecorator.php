<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\API\TypeResolvers\RootTypeResolver;
use PoP\API\TypeResolvers\SiteTypeResolver;
use PoP\UserRoles\Conditional\UserState\Environment;
use PoP\Users\TypeResolvers\UserTypeResolver;
use PoP\UserRoles\Conditional\UserState\TypeResolverDecorators\AbstractValidateDoesLoggedInUserHaveRoleForFieldsTypeResolverDecorator;

class RolesValidateDoesLoggedInUserHaveRoleForFieldsTypeResolverDecorator extends AbstractValidateDoesLoggedInUserHaveRoleForFieldsTypeResolverDecorator
{
    public static function getClassesToAttachTo(): array
    {
        return array(
            RootTypeResolver::class,
            SiteTypeResolver::class,
            UserTypeResolver::class,
        );
    }

    protected function getRoleName(): ?string
    {
        return Environment::roleLoggedInUserMustHaveToAccessRolesFields();
    }

    protected function getFieldNames(): array
    {
        return [
            'roles',
            'capabilities',
        ];
    }
}
