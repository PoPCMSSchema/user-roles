<?php

declare(strict_types=1);

namespace PoP\UserRoles;

use PoP\Root\Component\AbstractComponent;
use PoP\Root\Component\YAMLServicesTrait;
use PoP\ComponentModel\Container\ContainerBuilderUtils;

/**
 * Initialize component
 */
class Component extends AbstractComponent
{
    use YAMLServicesTrait;
    // const VERSION = '0.1.0';

    public static function getDependedComponentClasses(): array
    {
        return [
            \PoP\Users\Component::class,
        ];
    }

    /**
     * Initialize services
     */
    protected static function doInitialize(bool $skipSchema = false): void
    {
        parent::doInitialize($skipSchema);
        self::maybeInitYAMLSchemaServices(dirname(__DIR__), $skipSchema);
    }

    /**
     * Boot component
     *
     * @return void
     */
    public static function beforeBoot(): void
    {
        parent::beforeBoot();

        // Initialize all classes
        ContainerBuilderUtils::attachFieldResolversFromNamespace(__NAMESPACE__ . '\\FieldResolvers');
    }
}
