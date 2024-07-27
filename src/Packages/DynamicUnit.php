<?php
namespace SimpleCMS\DynamicUnit\Packages;

use Illuminate\Support\Collection;
use SimpleCMS\DynamicUnit\Models\DynamicAttribute;
use SimpleCMS\DynamicUnit\Models\DynamicUnit as DynamicUnitModel;

class DynamicUnit
{
    /**
     * 获取所有参数
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->convertUnit(DynamicUnitModel::all());
    }

    private function convertUnit(Collection $collection)
    {
        return $collection->map(function (DynamicUnitModel $item) {
            return new DynamicModel($item->name, $item->code, $item->items->map(fn(DynamicAttribute $dynamicAttribute) => new AttributeModel($dynamicAttribute->name, $dynamicAttribute->code)));
        });
    }

    /**
     * 按标识查询
     * @param string $code
     * @return mixed
     */
    public function findByCode(string $code)
    {
        return $this->convertUnit(DynamicUnitModel::where('code', $code)->all())->first();
    }

    /**
     * 获取属性选项
     * @param string $code
     * @return mixed
     */
    public function findListByCode(string $code)
    {
        return $this->findByCode($code)->items;
    }

    /**
     * 创建动态单元
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  array<{name|code|items},int|string|array<{name|code|file},int|string|UploadedFile>>   $array
     * @return bool
     */
    public function createUnit(array $array):bool
    {
        return DynamicQuery::create($array,'unit');
    }

    /**
     * 更新动态单元
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  int $id
     * @param  array<{name|code|items},int|string|array<{id|dynamic_unit_id|name|code|file},int|string|UploadedFile>>   $array
     * @return bool
     */
    public function updateUnit(int $id,array $array):bool
    {
        return DynamicQuery::update($id,$array,'unit');
    }

    /**
     * 删除动态单元
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  int $id
     * @return bool
     */
    public function deleteUnit(int $id):bool
    {
        return DynamicQuery::delete($id,'unit');
    }
    
    /**
     * 创建动态单元值
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  array<{dynamic_unit_id|name|code|file},int|string|UploadedFile>   $array
     * @return bool
     */
    public function createAttribute(array $array):bool
    {
        return DynamicQuery::create($array,'attribute');
    }

    /**
     * 更新动态单元值
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  int $id
     * @param  array<{dynamic_unit_id|name|code|file},int|string|UploadedFile>   $array
     * @return bool
     */
    public function updateAttribute(int $id,array $array):bool
    {
        return DynamicQuery::update($id,$array,'attribute');
    }

    /**
     * 删除动态单元值
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  int $id
     * @return bool
     */
    public function deleteAttribute(int $id):bool
    {
        return DynamicQuery::delete($id,'attribute');
    }
}