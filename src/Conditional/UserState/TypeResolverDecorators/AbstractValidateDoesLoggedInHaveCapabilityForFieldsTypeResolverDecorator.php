<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
use PoP\ComponentModel\TypeResolverDecorators\AbstractTypeResolverDecorator;
use PoP\UserRoles\Conditional\UserState\DirectiveResolvers\ValidateDoesLoggedInUserHaveCapabilityDirectiveResolver;

abstract class AbstractValidateDoesLoggedInHaveCapabilityForFieldsTypeResolverDecorator extends AbstractTypeResolverDecorator
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
        if ($requiredCapability = $this->getCapability()) {
            $fieldQueryInterpreter = FieldQueryInterpreterFacade::getInstance();
            // This is the directive to attach
            $validateDoesLoggedInUserHaveRoleDirective = $fieldQueryInterpreter->getDirective(
                ValidateDoesLoggedInUserHaveCapabilityDirectiveResolver::getDirectiveName(),
                [
                    'capability' => $requiredCapability,
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
    abstract protected function getCapability(): ?string;
    abstract protected function getFieldNames(): array;
}
