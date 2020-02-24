<?php
namespace PoP\UserRoles\Conditional\UserState;

class Environment
{
    public static function roleUserMustHaveToAccessRolesField(): ?string
    {
        return isset($_ENV['ROLE_USER_MUST_HAVE_TO_ACCESS_ROLES_FIELD']) && $_ENV['ROLE_USER_MUST_HAVE_TO_ACCESS_ROLES_FIELD'] ? strtolower($_ENV['ROLE_USER_MUST_HAVE_TO_TRANSLATE']) : null;
    }
}

