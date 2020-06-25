<?php

use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
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

    public function testRemoveHttp()
    {
        $url = 'https://www.php.net/manual/ru/function.stristr.php';

        $this->assertSame(
            '[php.net/manual/ru/function.stristr.php](' . $url . ')',
            short_line_for_md($url)
        );

        $url = 'http://www.php.net/manual/ru/function.stristr.php';

        $this->assertSame(
            '[php.net/manual/ru/function.stristr.php](' . $url . ')',
            short_line_for_md($url)
        );

        $url = 'https://php.net/manual/ru/function.stristr.php';

        $this->assertSame(
            '[php.net/manual/ru/function.stristr.php](' . $url . ')',
            short_line_for_md($url)
        );

        $url = 'http://php.net/manual/ru/function.stristr.php';

        $this->assertSame(
            '[php.net/manual/ru/function.stristr.php](' . $url . ')',
            short_line_for_md($url)
        );

        $url = 'www.php.net/manual/ru/function.stristr.php';

        $this->assertSame(
            '[php.net/manual/ru/function.stristr.php](' . $url . ')',
            short_line_for_md($url)
        );

        $url = 'https://www.php.net/manual/ru/function.stristr.php';

        $this->assertSame(
            '[php.net/manual/ru...](' . $url . ')',
            short_line_for_md($url, 20)
        );

        $url = 'text';

        $this->assertSame(
            'text',
            short_line_for_md($url)
        );
    }
}
