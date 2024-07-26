<?php

namespace SimpleCMS\Region;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use SimpleCMS\DynamicUnit\Services\DynamicAttributeService;
use SimpleCMS\Region\Services\DistanceService;
use SimpleCMS\Framework\Services\SimpleService;
use SimpleCMS\Region\Validation\Rule\RegionZipRule;
use SimpleCMS\Region\Validation\Rule\RegionAreaRule;
use SimpleCMS\Region\Validation\Rule\RegionCodeRule;
use SimpleCMS\Region\Validation\Rule\RegionNameRule;
use SimpleCMS\Region\Validation\Rule\RegionNumberRule;

class RegionServiceProvider extends ServiceProvider
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
