<?php

require_once __DIR__ . '/class-app-search-resource.php';

final class App_Search_Manager
{
    /**
     * @var array
     */
    private array $resources = [];

    /**
     * @param array $configs
     */
    private function __construct(array $configs)
    {
        $this->configure($configs);
    }

    /**
     * @param array|null $configs
     * @return self
     * @throws Exception
     */
    public static function instance(array $configs = null): self
    {
        static $instance = null;

        if (is_null($configs) && is_null($instance)) {
            throw new Exception('App_Search_Manager is not initialized yet.');
        }

        return $instance ?? $instance = new self($configs);
    }

    /**
     * @param array $configs
     * @return self
     * @throws Exception
     */
    public static function boot(array $configs): self
    {
        return self::instance($configs);
    }

    /**
     * @param string $slug
     * @return App_Search_Resource|null
     */
    public function getResource(string $slug): ?App_Search_Resource
    {
        return $this->resources[$slug] ?? null;
    }

    /**
     * @param array $configs
     * @return void
     */
    private function configure(array $configs)
    {
        foreach ($configs as $slug => $config) {
            $this->resources[$slug] = $this->createResource($slug, $config);
        }
    }

    /**
     * @param string $slug
     * @param array $config
     * @return App_Search_Resource
     */
    private function createResource(string $slug, array $config): App_Search_Resource
    {
        return App_Search_Resource::createFromConfig($slug, $config);
    }
}