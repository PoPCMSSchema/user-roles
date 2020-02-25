<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\UserRoles\Conditional\UserState\Environment;
use PoP\UserRoles\Conditional\UserState\TypeResolverDecorators\AbstractValidateDoesLoggedInUserHaveRoleForFieldsPublicSchemaTypeResolverDecorator;

class RolesValidateDoesLoggedInUserHaveRoleForFieldsPublicSchemaTypeResolverDecorator extends AbstractValidateDoesLoggedInUserHaveRoleForFieldsPublicSchemaTypeResolverDecorator
{
    use RolesValidateConditionForFieldsPublicSchemaTypeResolverDecoratorTrait;

    protected function getRoleNames(): array
    {
        if ($roleName = Environment::roleLoggedInUserMustHaveToAccessRolesFields()) {
            return [$roleName];
        }
        return [];
    }
}
