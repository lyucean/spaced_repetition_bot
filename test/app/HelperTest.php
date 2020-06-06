<?php

use PHPUnit\Framework\TestCase;

class ControllerTest extends TestCase
{
    public function testGetVarQuery()
    {
        $this->assertSame(
            ['content_id' => '123'],
            get_var_query('/content/cancel?content_id=123')
        );

        $this->assertSame(
            ['a' => '1', 't' => '2'],
            get_var_query('/content/cancel?a=1&t=2')
        );

        $this->assertSame(
            [],
            get_var_query('/content/cancel')
        );
    }
}
