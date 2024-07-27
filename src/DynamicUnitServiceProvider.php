<?php

namespace SimpleCMS\DynamicUnit;

use Illuminate\Support\ServiceProvider;
use SimpleCMS\Framework\Services\SimpleService;
use SimpleCMS\DynamicUnit\Services\DynamicAttributeService;

class DynamicUnitServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->bootConfig();
        $this->loadFacades();
        $this->bindMacroService();
    }

    /**
     * 修改query
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return void
     */
    protected function bindMacroService(): void
    {
        if (class_exists(SimpleService::class)) {
            SimpleService::macro('queryAttribute', function (SimpleService $service, array $parameters) {
                $attributeService = new DynamicAttributeService;
                return $attributeService->queryAttribute($service,$parameters);
            });
        }
    }

    /**
     * 绑定Facades
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return void
     */
    protected function loadFacades(): void
    {
        $this->app->bind('dynamic_unit', fn() => new \SimpleCMS\DynamicUnit\Packages\DynamicUnit);
    }

    /**
     * 初始化配置文件
     * @return void
     */
    protected function bootConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'simplecms');
    }
}
