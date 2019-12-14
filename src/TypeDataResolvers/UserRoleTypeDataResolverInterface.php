<?php
namespace PoP\UserRoles\TypeDataResolvers;

interface UserRoleTypeDataResolverInterface {
    /**
     * Role names
     *
     * @return array
     */
    public function getRoleNames(): array;
}
