<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\API\TypeResolvers\RootTypeResolver;
use PoP\API\TypeResolvers\SiteTypeResolver;
use PoP\UserRoles\Conditional\UserState\Environment;
use PoP\Users\TypeResolvers\UserTypeResolver;
use PoP\UserRoles\Conditional\UserState\TypeResolverDecorators\AbstractValidateDoesLoggedInHaveCapabilityForFieldsTypeResolverDecorator;

class RolesValidateDoesLoggedInHaveCapabilityForFieldsTypeResolverDecorator extends AbstractValidateDoesLoggedInHaveCapabilityForFieldsTypeResolverDecorator
{
    public static function getClassesToAttachTo(): array
    {
        return array(
            RootTypeResolver::class,
            SiteTypeResolver::class,
            UserTypeResolver::class,
        );
    }

    protected function getCapability(): ?string
    {
        return Environment::capabilityLoggedInUserMustHaveToAccessRolesFields();
    }

    protected function getFieldNames(): array
    {
        return [
            'roles',
            'capabilities',
        ];
    }
}
