<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
use PoP\AccessControl\TypeResolverDecorators\AbstractPublicSchemaTypeResolverDecorator;
use PoP\UserRolesAccessControl\DirectiveResolvers\ValidateDoesLoggedInUserHaveAnyRoleDirectiveResolver;

abstract class AbstractValidateDoesLoggedInUserHaveRoleForDirectivesPublicSchemaTypeResolverDecorator extends AbstractPublicSchemaTypeResolverDecorator
{
    /**
     * By default, only the admin can see the roles from the users
     *
     * @param TypeResolverInterface $typeResolver
     * @return array
     */
    public function getMandatoryDirectivesForDirectives(TypeResolverInterface $typeResolver): array
    {
        $mandatoryDirectivesForDirectives = [];
        if ($roleNames = $this->getRoleNames()) {
            $fieldQueryInterpreter = FieldQueryInterpreterFacade::getInstance();
            // This is the directive to attach
            $validateDoesLoggedInUserHaveAnyRoleDirective = $fieldQueryInterpreter->getDirective(
                ValidateDoesLoggedInUserHaveAnyRoleDirectiveResolver::getDirectiveName(),
                [
                    'roles' => $roleNames,
                ]
            );
            if ($directiveNames = array_map(
                function($directiveResolverClass) {
                    return $directiveResolverClass::getDirectiveName();
                },
                $this->getDirectiveResolverClasses()
            )) {
                foreach ($directiveNames as $directiveName) {
                    $mandatoryDirectivesForDirectives[$directiveName] = [
                        $validateDoesLoggedInUserHaveAnyRoleDirective,
                    ];
                }
            }
        }
        return $mandatoryDirectivesForDirectives;
    }
    abstract protected function getRoleNames(): array;
    abstract protected function getDirectiveResolverClasses(): array;
}
