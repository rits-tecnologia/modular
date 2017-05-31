<?php

namespace Tests\Rits;

use Illuminate\Foundation\Application;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * Laravel application is successfully configured.
     */
    public function testCanCreateApplication()
    {
        $this->assertEquals(get_class(app()), Application::class);
    }
}
