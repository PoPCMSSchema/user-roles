<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
use PoP\AccessControl\TypeResolverDecorators\AbstractPublicSchemaTypeResolverDecorator;
use PoP\UserRoles\Conditional\UserState\DirectiveResolvers\ValidateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver;

abstract class AbstractValidateDoesLoggedInUserHaveCapabilityForFieldsPublicSchemaTypeResolverDecorator extends AbstractPublicSchemaTypeResolverDecorator
{
    /**
     * By default, only the admin can see the roles from the users
     *
     * @param TypeResolverInterface $typeResolver
     * @return array
     */
    public function getMandatoryDirectivesForFields(TypeResolverInterface $typeResolver): array
    {
        $mandatoryDirectivesForFields = [];
        if ($capabilities = $this->getCapabilities()) {
            $fieldQueryInterpreter = FieldQueryInterpreterFacade::getInstance();
            // This is the directive to attach
            $validateDoesLoggedInUserHaveAnyRoleDirective = $fieldQueryInterpreter->getDirective(
                ValidateDoesLoggedInUserHaveAnyCapabilityDirectiveResolver::getDirectiveName(),
                [
                    'capabilities' => $capabilities,
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
    abstract protected function getCapabilities(): array;
    abstract protected function getFieldNames(): array;
}
