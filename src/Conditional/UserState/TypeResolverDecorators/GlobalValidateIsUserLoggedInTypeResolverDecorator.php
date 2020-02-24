<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\ComponentModel\TypeResolvers\AbstractTypeResolver;
use PoP\UserState\TypeResolverDecorators\AbstractValidateIsUserLoggedInTypeResolverDecorator;
use PoP\UserRoles\Conditional\UserState\DirectiveResolvers\ValidateDoesLoggedInUserHaveRoleDirectiveResolver;
use PoP\UserRoles\Conditional\UserState\DirectiveResolvers\ValidateDoesLoggedInUserHaveCapabilityDirectiveResolver;

class GlobalValidateIsUserLoggedInTypeResolverDecorator extends AbstractValidateIsUserLoggedInTypeResolverDecorator
{
    public static function getClassesToAttachTo(): array
    {
        return array(
            AbstractTypeResolver::class,
        );
    }

    /**
     * Provide the classes for all the directiveResolverClasses that need the "validateIsUserLoggedIn" directive
     *
     * @return array
     */
    protected function getDirectiveResolverClasses(): array
    {
        return [
            ValidateDoesLoggedInUserHaveRoleDirectiveResolver::class,
            ValidateDoesLoggedInUserHaveCapabilityDirectiveResolver::class,
        ];
    }
}
