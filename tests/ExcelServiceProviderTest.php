<?php

namespace Maatwebsite\Excel\Tests;

use Maatwebsite\Excel\Excel;

class ExcelServiceProviderTest extends TestCase
{
    /**
     * @test
     */
    public function is_bound()
    {
        $this->assertTrue($this->app->bound('excel'));
    }

    /**
     * @test
     */
    public function has_aliased()
    {
        $this->assertTrue($this->app->isAlias(Excelvthree::class));
        $this->assertEquals('excel', $this->app->getAlias(Excelvthree::class));
    }
}
