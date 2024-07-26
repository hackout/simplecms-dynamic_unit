<?php

namespace SimpleCMS\DynamicUnit\Traits;

use SimpleCMS\DynamicUnit\Models\CustomAttribute;

/**
 * 动态单元Trait
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 *
 * 使用:
 * 
 *   use \SimpleCMS\DynamicUnit\Traits\DynamicAttributeTrait;
 *
 *
 * 请求查询方法:
 *
 *   $query->withAttributeCodes(array $codes);
 * 
 * @use \Illuminate\Database\Eloquent\Model
 * @use \Illuminate\Database\Eloquent\Concerns\HasRelationships
 *
 */
trait DynamicAttributeTrait
{

    public static function bootDynamicAttributeTrait()
    {
        static::deleting(function ($model) {
            $model->customsAttributes->each(fn(CustomAttribute $customsAttribute) => $customsAttribute->delete());
        });
    }

    /**
     * 动态单元
     * @return mixed
     */
    public function customsAttributes()
    {
        return $this->morphMany(CustomAttribute::class, 'model');
    }

    /**
     * 动态单元查询
     * @param mixed $query
     * @param array $codes
     * @return mixed
     */
    public function scopeWithAttributeCodes($query, array $codes)
    {
        return $query->whereHas('customsAttributes', function ($q) use ($codes) {
            $q->whereIn('dynamic_attribute_id', function ($subQuery) use ($codes) {
                $subQuery->select('id')
                    ->from('dynamic_attributes')
                    ->whereIn('code', $codes);
            });
        });
    }

}
