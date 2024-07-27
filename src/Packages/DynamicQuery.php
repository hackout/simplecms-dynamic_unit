<?php
namespace SimpleCMS\DynamicUnit\Packages;

use Illuminate\Http\UploadedFile;
use SimpleCMS\DynamicUnit\Models\DynamicAttribute;
use SimpleCMS\DynamicUnit\Models\DynamicUnit as DynamicUnitModel;

/**
 * 操作类
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class DynamicQuery
{

    /**
     * 删除动作
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  int $id
     * @param  string $type
     * @return bool
     */
    public static function delete(int $id,string $type):bool
    {
        $model = self::convertModel($type);
        if(!$item = $model::find($id))
        {
            return false;
        }
        return $item->delete();
    }

    /**
     * 添加动作
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  array $data
     * @return bool
     */
    public static function create(array $data,string $type):bool
    {
        $model = self::convertModel($type);
        $file = null;
        if($type == 'attribute')
        {
            $sql = self::convertAttributeSql($data);
            $file = self::pullFile($data);
        }else{
            $sql = self::convertUnitSql($data);
        }
        if($item = $model::create($sql))
        {
            if($file)
            {
                $item->addMedia($file)->toMediaCollection($model::MEDIA_FILE);
            }
        }
        if($type == 'unit' && array_key_exists('items',$array) && $array['items'])
        {
            foreach($array['items'] as $rs)
            {
                self::create(array_merge(['dynamic_unit_id'=>$item->id],$rs),'attribute');
            }
        }
        return !empty($item);
    }

    /**
     * 修改动作
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  int $id
     * @param  array $data
     * @return bool
     */
    public static function update(int $id,array $data,string $type):bool
    {
        $model = self::convertModel($type);
        if(!$item = $model::find($id))
        {
            return false;
        }
        $file = null;
        if($type == 'attribute')
        {
            $sql = self::convertAttributeSql($data);
            $file = self::pullFile($data);
        }else{
            $sql = self::convertUnitSql($data);
        }
        $item->fill($sql);
        if($result = $item->save())
        {
            if($file)
            {
                $item->media && $item->media->each(fn($media)=>$media->delete());
                $item->addMedia($file)->toMediaCollection($model::MEDIA_FILE);
            }
        }
        if($type == 'unit' && array_key_exists('items',$array) && $array['items'])
        {
            self::removeUnderId($item,$array['items']);
            foreach($array['items'] as $rs)
            {
                if(array_key_exists('id',$rs) && $rs['id'])
                {
                    self::update((int) $rs['id'],array_merge(['dynamic_unit_id'=>$item->id],$rs),'attribute');
                }else{
                    self::create(array_merge(['dynamic_unit_id'=>$item->id],$rs),'attribute');
                }
            }
        }
        return $result;
    }

    private static function removeUnderId(DynamicUnitModel $item,array $array):void
    {
        $collection = new Collection($array);
        $idList = $collection->filter(fn($n)=>isset($n['id']) && !empty($n['id']))->values()->pluck('id')->toArray();
        if($idList)
        {
            $item->items()->whereNotIn('id',$idList)->delete();
        }
    }

    private static function convertModel(string $type)
    {
        return $type == 'attribute' ? DynamicAttribute::class : DynamicUnitModel::class;
    }

    
    private static function convertSql(array $data):array|bool
    {
        $sql = [];
        if(array_key_exists('name',$data) && trim($data['name']))
        {
            $sql['name'] = trim($data['name']);
        }
        if(array_key_exists('code',$data) && trim($data['code']))
        {
            $sql['code'] = trim($data['code']);
        }
        if(!$sql) return false;
        $file = array_key_exists("file",$data) ? $data['file'] : null;
        $id = array_key_exists("id",$data) ? $data['id'] : null;
        return [$sql,$file,$id];
    }

    private static function pullFile(array $data):null|UploadedFile
    {
        if(array_key_exists('file',$data) && $data['file'])
        {
            return $data['file'] instanceof UploadedFile ? $data['file'] : null;
        }
        return null;
    }

    private static function convertAttributeSql(array $data):array
    {
        $sql = array_merge([
            'dynamic_unit_id' => 0,
            'name' => null,
            'code' => null
        ],$data);
        $collection = new Collection($sql);
        return $collection->only(['dynamic_unit_id','name','code'])->toArray();
    }

    private static function convertUnitSql(array $data):array
    {
        $sql = array_merge([
            'name' => null,
            'code' => null
        ],$data);
        $collection = new Collection($sql);
        return $collection->only(['name','code'])->toArray();
    }
}