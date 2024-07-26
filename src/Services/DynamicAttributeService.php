<?php

namespace SimpleCMS\DynamicUnit\Services;

use SimpleCMS\Framework\Services\SimpleService;

class DynamicAttributeService
{

    /**
     * 按自定义标识查询
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleService $service
     * @param  float         $lat
     * @param  float         $lng
     * @param  integer       $maxDistance
     * @param  string        $column
     * @return SimpleService
     */
    public function queryAttribute(SimpleService $service, array $parameters): SimpleService
    {
        $service->setQuery(function ($query) use ($parameters) {
            $query->whereHas('customsAttributes', function ($q) use ($parameters) {
                $q->whereIn('dynamic_attribute_id', function ($subQuery) use ($parameters) {
                    $subQuery->select('id')
                        ->from('dynamic_attributes')
                        ->whereIn('code', $parameters);
                });
            });
        });
        return $service;
    }
}