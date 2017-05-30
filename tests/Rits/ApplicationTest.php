<?php

namespace Tests\Rits;

use Illuminate\Foundation\Application;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * registry must return the fallback value if the key does'nt exist.
     */
    public function testCanCreateApplication()
    {
        $this->assertEquals(get_class(app()), Application::class);
    }
}
