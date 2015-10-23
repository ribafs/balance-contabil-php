<?php

namespace Balance\Posting;

use PHPUnit_Framework_TestCase as TestCase;

class CheckerTest extends TestCase
{
    public function testSimpleAddValue()
    {
        $checker = new Checker();

        $result = $checker->addValue(Checker::CREDIT, 1.0);
        $this->assertFalse($checker->isValid());
        $this->assertSame($checker, $result);

        $checker->addValue(Checker::DEBIT, 1.0);
        $this->assertTrue($checker->isValid());
    }

    public function testComplexAddValue()
    {
        $checker = new Checker();

        $checker->addValue(Checker::CREDIT, 0.1);
        $checker->addValue(Checker::CREDIT, 0.2);
        $checker->addValue(Checker::CREDIT, 0.3);

        $checker->addValue(Checker::DEBIT, 0.6);

        $this->assertTrue($checker->isValid());
    }

    public function testAddDecimalValue()
    {
        $checker = new Checker();

        $checker->addValue(Checker::CREDIT, 1.0);
        $checker->addValue(Checker::DEBIT, 1.001);

        $this->assertTrue($checker->isValid());
    }

    public function testAddValueWithInvalidType()
    {
        $this->setExpectedException('InvalidArgumentException');

        (new Checker())->addValue('UNKNOWN', 0);
    }

    public function testDifference()
    {
        $checker = new Checker();

        $checker->addValue(Checker::CREDIT, 5.00);
        $checker->addValue(Checker::DEBIT, 4.99);

        $this->assertEquals(0.01, $checker->getDifference());
    }
}
