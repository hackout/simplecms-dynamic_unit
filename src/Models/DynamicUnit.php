<?php

namespace SimpleCMS\DynamicUnit\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * DynamicUnit
 * 
 * @property int $id 主键
 * @property string $name 名称
 * @property ?string $code 标识
 * @property-read ?\Illuminate\Database\Eloquent\Collection<DynamicAttribute> $items 属性值
 * @property-read \Carbon\Carbon $created_at 创建时间
 * @property-read ?\Carbon\Carbon $updated_at 更新时间
 */
class DynamicUnit extends Model
{

    protected $fillable = [
        'name',
        'code',
    ];

    public $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * 属性值
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(DynamicAttribute::class);
    }
}
