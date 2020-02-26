<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
use PoP\AccessControl\TypeResolverDecorators\AbstractPublicSchemaTypeResolverDecorator;
use PoP\UserRoles\Conditional\UserState\DirectiveResolvers\ValidateDoesLoggedInUserHaveAnyRoleDirectiveResolver;

abstract class AbstractValidateDoesLoggedInUserHaveRoleForFieldsPublicSchemaTypeResolverDecorator extends AbstractPublicSchemaTypeResolverDecorator
{
    protected function onlyForPublicSchema(): bool
    {
        return true;
    }
    /**
     * By default, only the admin can see the roles from the users
     *
     * @param TypeResolverInterface $typeResolver
     * @return array
     */
    public function getMandatoryDirectivesForFields(TypeResolverInterface $typeResolver): array
    {
        $mandatoryDirectivesForFields = [];
        if ($roleNames = $this->getRoleNames()) {
            $fieldQueryInterpreter = FieldQueryInterpreterFacade::getInstance();
            // This is the directive to attach
            $validateDoesLoggedInUserHaveAnyRoleDirective = $fieldQueryInterpreter->getDirective(
                ValidateDoesLoggedInUserHaveAnyRoleDirectiveResolver::getDirectiveName(),
                [
                    'roles' => $roleNames,
                ]
            );
            foreach ($this->getFieldNames() as $fieldName) {
                $mandatoryDirectivesForFields[$fieldName] = [
                    $validateDoesLoggedInUserHaveAnyRoleDirective,
                ];
            }
        }
        return $mandatoryDirectivesForFields;
    }
    abstract protected function getRoleNames(): array;
    abstract protected function getFieldNames(): array;
}
