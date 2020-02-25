<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\UserRoles\Conditional\UserState\Environment;
use PoP\UserRoles\Conditional\UserState\TypeResolverDecorators\AbstractValidateDoesLoggedInUserHaveRoleForFieldsTypeResolverDecorator;

class RolesValidateDoesLoggedInUserHaveRoleForFieldsTypeResolverDecorator extends AbstractValidateDoesLoggedInUserHaveRoleForFieldsTypeResolverDecorator
{
    use RolesValidateConditionForFieldsTypeResolverDecoratorTrait;

    protected function getRoleName(): ?string
    {
        return Environment::roleLoggedInUserMustHaveToAccessRolesFields();
    }
}
