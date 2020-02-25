<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
use PoP\ComponentModel\TypeResolverDecorators\AbstractPublicSchemaTypeResolverDecorator;
use PoP\UserRoles\Conditional\UserState\DirectiveResolvers\ValidateDoesLoggedInUserHaveCapabilityDirectiveResolver;

abstract class AbstractValidateDoesLoggedInUserHaveCapabilityForDirectivesPublicSchemaTypeResolverDecorator extends AbstractPublicSchemaTypeResolverDecorator
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
        if ($capabilities = $this->getCapabilities()) {
            $fieldQueryInterpreter = FieldQueryInterpreterFacade::getInstance();
            // This is the directive to attach
            $validateDoesLoggedInUserHaveCapabilityDirective = $fieldQueryInterpreter->getDirective(
                ValidateDoesLoggedInUserHaveCapabilityDirectiveResolver::getDirectiveName(),
                [
                    'capabilities' => $capabilities,
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
                        $validateDoesLoggedInUserHaveCapabilityDirective,
                    ];
                }
            }
        }
        return $mandatoryDirectivesForDirectives;
    }
    abstract protected function getCapabilities(): array;
    abstract protected function getDirectiveResolverClasses(): array;
}
