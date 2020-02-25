<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\UserRoles\Conditional\UserState\Environment;
use PoP\UserRoles\Conditional\UserState\TypeResolverDecorators\AbstractValidateDoesLoggedInUserHaveCapabilityForFieldsTypeResolverDecorator;

class RolesValidateDoesLoggedInUserHaveCapabilityForFieldsTypeResolverDecorator extends AbstractValidateDoesLoggedInUserHaveCapabilityForFieldsTypeResolverDecorator
{
    use RolesValidateConditionForFieldsTypeResolverDecoratorTrait;

    protected function getCapability(): ?string
    {
        return Environment::capabilityLoggedInUserMustHaveToAccessRolesFields();
    }
}
