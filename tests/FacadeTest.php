<?php
namespace SimpleCMS\DynamicUnit\Tests;

use SimpleCMS\DynamicUnit\Packages\DynamicUnit;
use SimpleCMS\DynamicUnit\Models\DynamicUnit as DynamicUnitModel;

class FacadeTest extends \PHPUnit\Framework\TestCase
{

    public function testBankList()
    {
        $dynamicUnit = DynamicUnitModel::factory()->create();
        echo($dynamicUnit->name);
    }
}