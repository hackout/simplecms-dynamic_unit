<?php

namespace SimpleCMS\DynamicUnit\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use SimpleCMS\Framework\Traits\MediaAttributeTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * DynamicAttribute
 * 
 * @property int $id 主键
 * @property int $dynamic_unit_id 属性ID
 * @property string $name 名称
 * @property ?string $code 键值参数
 * 
 * @property-read ?\Carbon\Carbon $created_at 创建时间
 * @property-read ?\Carbon\Carbon $updated_at 更新时间
 * @property-read ?array<string,string> $thumbnail 附件信息
 * @property-read ?DynamicUnit $dynamicUnit 属性
 * @property-read ?\Illuminate\Database\Eloquent\Collection<Media> $media 附件
 * @property-read ?\Illuminate\Database\Eloquent\Collection<CustomAttribute> $customsAttributes 自定义属性
 */
class DynamicAttribute extends Model implements HasMedia
{
    use MediaAttributeTrait,HasFactory;

    const MEDIA_FILE = 'file';

    protected $fillable = [
        'dynamic_unit_id',
        'name',
        'code',
    ];

    public $casts = [
        'thumbnail' => 'json',
        'dynamic_unit_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * 追加字段
     */
    public $appends = ['thumbnail'];


    /**
     * 隐藏关系
     */
    public $hidden = ['media'];

    /**
     * 属性类型
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dynamicUnit()
    {
        return $this->belongsTo(DynamicAttribute::class);
    }

    /**
     * 自定义属性
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function customsAttributes()
    {
        return $this->morphMany(CustomAttribute::class,'model');
    }

    public function getThumbnailAttribute()
    {
        if (!$media = $this->getFirstMedia(self::MEDIA_FILE))
            return [];
        return [
            'name' => $media->file_name,
            'url' => $media->original_url,
            'uuid' => $media->uuid
        ];
    }
}
