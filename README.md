# SimpleCMS/Laravel Dynamic Unit Component

📦  A dynamic unit component that combines the functionality of SKU and dict dictionary.

English | [简体中文](./README_zhCN.md)

[![Latest Stable Version](https://poser.pugx.org/simplecms/dynamic_unit/v/stable.svg)](https://packagist.org/packages/simplecms/dynamic_unit) [![Latest Unstable Version](https://poser.pugx.org/simplecms/dynamic_unit/v/unstable.svg)](https://packagist.org/packages/simplecms/dynamic_unit) [![Code Coverage](https://scrutinizer-ci.com/g/overtrue/easy-sms/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/hackout/simplecms-dynamic_unit/?branch=master) [![Total Downloads](https://poser.pugx.org/simplecms/dynamic_unit/downloads)](https://packagist.org/packages/simplecms/dynamic_unit) [![License](https://poser.pugx.org/simplecms/dynamic_unit/license)](https://packagist.org/packages/simplecms/dynamic_unit)

## Requirements

- PHP >= 8.2
- MySql >= 8.0
- [Laravel/Framework](https://packagist.org/packages/laravel/framework) >= 11.0
- [SimpleCMS/Framework](https://packagist.org/packages/simplecms/framework) >= 1.0

## Installation

```bash
composer require simplecms/dynamic_unit
```

## Usage

### Model Usage

Use ```DynamicAttributeTrait``` to associate with the model.

```php
use \SimpleCMS\DynamicUnit\Traits\DynamicAttributeTrait;
```

The model will automatically associate with the ```customsAttributes``` morphMany relationship

#### SCOPE

Query model attributes values

```php
$array = ['red','blue'];
$query->withAttributeCodes($array);
```

### Facades

```php
use SimpleCMS\DynamicUnit\Facades\DynamicUnit; 
DynamicUnit::getAll(); //Get all parameters
DynamicUnit::findByCode(string $code); //Find by code
DynamicUnit::findListByCode(string $code); //Get attribute options
DynamicUnit::createUnit(array<{name|code|items},int|string|array<{name|code|file},int|string|UploadedFile>> $array); //Create dynamic unit
DynamicUnit::updateUnit(int $id,array<{name|code|items},int|string|array<{id|dynamic_unit_id|name|code|file},int|string|UploadedFile>> $array); //Update dynamic unit
DynamicUnit::deleteUnit(int $id); //Delete dynamic unit
DynamicUnit::createAttribute(array<{dynamic_unit_id|name|code|file},int|string|UploadedFile> $array); //Create dynamic unit value
DynamicUnit::updateAttribute(int $id,array<{dynamic_unit_id|name|code|file},int|string|UploadedFile> $array); //Update dynamic unit value
DynamicUnit::deleteAttribute(int $id); //Delete dynamic unit value
```

## SimpleCMS Extension

Please load ```simplecms/framework``` first.

### Service Calls

```php
use SimpleService; 
//Add dynamic unit value query 
$service->queryAttribute(array $codes)
```

## License

MIT
