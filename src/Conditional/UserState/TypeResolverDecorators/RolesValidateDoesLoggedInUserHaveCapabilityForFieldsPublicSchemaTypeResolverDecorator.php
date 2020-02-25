<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\UserRoles\Conditional\UserState\Environment;
use PoP\UserRoles\Conditional\UserState\TypeResolverDecorators\AbstractValidateDoesLoggedInUserHaveCapabilityForFieldsPublicSchemaTypeResolverDecorator;

class RolesValidateDoesLoggedInUserHaveCapabilityForFieldsPublicSchemaTypeResolverDecorator extends AbstractValidateDoesLoggedInUserHaveCapabilityForFieldsPublicSchemaTypeResolverDecorator
{
    use RolesValidateConditionForFieldsPublicSchemaTypeResolverDecoratorTrait;

    protected function getCapabilities(): array
    {
        if ($capability = Environment::capabilityLoggedInUserMustHaveToAccessRolesFields()) {
            return [$capability];
        }
        return [];
    }
}
