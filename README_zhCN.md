# SimpleCMS/Laravel 动态单元组件

📦 一个动态单元组件，用法结合了SKU和dict字典的功能

简体中文 | [English](./README.md)

[![Latest Stable Version](https://poser.pugx.org/simplecms/dynamic_unit/v/stable.svg)](https://packagist.org/packages/simplecms/dynamic_unit) [![Latest Unstable Version](https://poser.pugx.org/simplecms/dynamic_unit/v/unstable.svg)](https://packagist.org/packages/simplecms/dynamic_unit) [![Code Coverage](https://scrutinizer-ci.com/g/overtrue/easy-sms/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/hackout/simplecms-dynamic_unit/?branch=master) [![Total Downloads](https://poser.pugx.org/simplecms/dynamic_unit/downloads)](https://packagist.org/packages/simplecms/dynamic_unit) [![License](https://poser.pugx.org/simplecms/dynamic_unit/license)](https://packagist.org/packages/simplecms/dynamic_unit)

## 环境需求

- PHP >= 8.2
- MySql >= 8.0
- [Laravel/Framework](https://packagist.org/packages/laravel/framework) >= 11.0
- [SimpleCMS/Framework](https://packagist.org/packages/simplecms/framework) >= 1.0

## 安装

```bash
composer require simplecms/dynamic_unit
```

## 使用方法

### Model模型使用

使用```DynamicAttributeTrait```对模型进行关联

```php
use \SimpleCMS\DynamicUnit\Traits\DynamicAttributeTrait;
```

模型会自动关联上```customsAttributes```这个morphMany关系

#### SCOPE

查询模型attributes值

```php
$array = ['red','blue'];
$query->withAttributeCodes($array);
```

### Facades

```php
use SimpleCMS\DynamicUnit\Facades\DynamicUnit; 

DynamicUnit::getAll(); //获取所有参数
DynamicUnit::findByCode(string $code); //按标识查询
DynamicUnit::findListByCode(string $code); //获取属性选项
DynamicUnit::createUnit(array<{name|code|items},int|string|array<{name|code|file},int|string|UploadedFile>> $array); //创建动态单元
DynamicUnit::updateUnit(int $id,array<{name|code|items},int|string|array<{id|dynamic_unit_id|name|code|file},int|string|UploadedFile>> $array); //更新动态单元
DynamicUnit::deleteUnit(int $id); //删除动态单元
DynamicUnit::createAttribute(array<{dynamic_unit_id|name|code|file},int|string|UploadedFile> $array); //创建动态单元值
DynamicUnit::updateAttribute(int $id,array<{dynamic_unit_id|name|code|file},int|string|UploadedFile> $array); //更新动态单元值
DynamicUnit::deleteAttribute(int $id); //删除动态单元值
```

## SimpleCMS扩展

请先加载```simplecms/framework```

### 服务调用

```php
use SimpleService;

//添加动态单元值查询
$service->queryAttribute(array $codes)
```

## License

MIT
