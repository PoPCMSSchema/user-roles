<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
use PoP\ComponentModel\TypeResolverDecorators\AbstractPublicSchemaTypeResolverDecorator;
use PoP\UserRoles\Conditional\UserState\DirectiveResolvers\ValidateDoesLoggedInUserHaveRoleDirectiveResolver;

abstract class AbstractValidateDoesLoggedInUserHaveRoleForFieldsTypeResolverDecorator extends AbstractPublicSchemaTypeResolverDecorator
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
        if ($requiredRoleName = $this->getRoleName()) {
            $fieldQueryInterpreter = FieldQueryInterpreterFacade::getInstance();
            // This is the directive to attach
            $validateDoesLoggedInUserHaveRoleDirective = $fieldQueryInterpreter->getDirective(
                ValidateDoesLoggedInUserHaveRoleDirectiveResolver::getDirectiveName(),
                [
                    'role' => $requiredRoleName,
                ]
            );
            foreach ($this->getFieldNames() as $fieldName) {
                $mandatoryDirectivesForFields[$fieldName] = [
                    $validateDoesLoggedInUserHaveRoleDirective,
                ];
            }
        }
        return $mandatoryDirectivesForFields;
    }
    abstract protected function getRoleName(): ?string;
    abstract protected function getFieldNames(): array;
}
