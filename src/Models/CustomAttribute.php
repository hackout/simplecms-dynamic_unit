<?php

namespace SimpleCMS\DynamicUnit\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use SimpleCMS\Framework\Traits\MediaAttributeTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * DynamicAttribute
 * 
 * @property int $id 主键
 * @property int $dynamic_attribute_id 单元ID
 * @property string $model_id 关联ID
 * @property ?class-string $model_type 关联类
 * @property array $extra 自定义参数
 * 
 * @property-read ?\Carbon\Carbon $created_at 创建时间
 * @property-read ?\Carbon\Carbon $updated_at 更新时间
 * @property-read ?array<string,string> $thumbnail 附件信息
 * @property-read ?DynamicAttribute $dynamicAttribute 单元
 * @property-read ?\Illuminate\Database\Eloquent\Collection<Media> $media 附件
 * @property-read mixed $model 上级
 */
class CustomAttribute extends Model implements HasMedia
{
    use MediaAttributeTrait;
    protected $fillable = [
        'dynamic_attribute_id',
        'model_id',
        'model_type',
        'extra',
    ];

    public $casts = [
        'extra' => 'json',
        'thumbnail' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * 动态单元
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dynamicAttribute()
    {
        return $this->belongsTo(DynamicAttribute::class);
    }

    /**
     * 关联模型
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo();
    }
}
