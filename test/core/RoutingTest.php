<?php

namespace srbot\core;

use PHPUnit\Framework\TestCase;

class RoutingTest extends TestCase
{
    public function testIndexRandomText()
    {
        $this->assertSame(
            'Start',
            (new Routing())->index(123, 'test')
        );
    }
    public function testIndexWaitingController()
    {
        // Создать заглушку для класса SomeClass.
        $stub = $this->createMock(DB::class);

        // Настроить заглушку.
        $stub->method('getLastRoute')
            ->will($this->returnArgument(0));
        // Настроить заглушку.
        $stub->method('->db->getLastRoute')
            ->willReturn(['controller' => 'WaitingController']);

        // $stub->doSomething('foo') вернёт 'foo'
//        $this->assertSame('foo', $stub->getLastRoute('foo'));
        $this->assertSame(
            ['controller' => 'WaitingController'],
            (new Routing())->index(123435, 'test')
        );
    }

    public function testRequireFile()
    {
        $this->assertTrue((new Routing())->requireFile("Start"));
    }
}
