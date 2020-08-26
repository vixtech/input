<?php

declare(strict_types=1);

namespace Linio\Component\Input\Node;

use Linio\Component\Input\Constraint\ConstraintInterface;
use Linio\Component\Input\Exception\InvalidConstraintException;
use Linio\Component\Input\TypeHandler;
use PHPUnit\Framework\TestCase;
use Linio\Component\Input\Transformer\DateTimeTransformer;

class ScalarCollectionNodeTest extends TestCase
{
    public function testIsGettingValue(): void
    {
        $typeHandler = $this->prophesize(TypeHandler::class);
        $typeHandler->getType('int')->willReturn(new ScalarCollectionNode());

        $base = new ScalarCollectionNode();
        $base->setTypeHandler($typeHandler->reveal());
        $child = $base->add('foobar', 'int');
        $child->setType('int');
        $this->assertEquals([15, 25, 36], $child->getValue('foobar', [15, 25, 36]));
    }

    public function testIsDetectingBadTypes(): void
    {
        $typeHandler = $this->prophesize(TypeHandler::class);
        $typeHandler->getType('int')->willReturn(new ScalarCollectionNode());

        $base = new ScalarCollectionNode();
        $base->setTypeHandler($typeHandler->reveal());
        $child = $base->add('foobar', 'int');
        $child->setType('int');

        $this->expectException(InvalidConstraintException::class);
        $this->expectExceptionMessage('Value "25" is not of type int');
        $child->getValue('foobar', [15, '25']);
    }

    public function testIsCheckingConstraintsOnValue(): void
    {
        $typeHandler = $this->prophesize(TypeHandler::class);
        $typeHandler->getType('int')->willReturn(new ScalarCollectionNode());

        $constraint = $this->prophesize(ConstraintInterface::class);
        $constraint->validate([15, 25, 36])->willReturn(false);
        $constraint->getErrorMessage('foobar')->shouldBeCalled();

        $base = new ScalarCollectionNode();
        $base->setTypeHandler($typeHandler->reveal());
        $child = $base->add('foobar', 'int', ['constraints' => [$constraint->reveal()]]);
        $child->setType('int');

        $this->expectException(InvalidConstraintException::class);
        $child->getValue('foobar', [15, 25, 36]);
    }

    public function testIsCheckingIfIsIterable(): void
    {
        $typeHandler = $this->prophesize(TypeHandler::class);
        $typeHandler->getType('int[]')->willReturn(new ScalarCollectionNode());

        $base = new ScalarCollectionNode();
        $base->setTypeHandler($typeHandler->reveal());
        $child = $base->add('foobar', 'int[]');
        $child->setType('int');

        $this->expectException(InvalidConstraintException::class);
        $child->getValue('foobar', 'foobar');
    }

    public function testIsGetTransformed()
    {
        $typeHandler = $this->prophesize(TypeHandler::class);
        $typeHandler->getType('string')->willReturn(new ScalarCollectionNode());

        $base = new ScalarCollectionNode();
        $base->setTypeHandler($typeHandler->reveal());
        $child = $base->add('foobar', 'string', ['transformer' => new DateTimeTransformer()]);
        $child->setType('string');
        $this->assertEquals(
            [new \DateTime('2014-01-01 00:00:00')],
            $child->getValue('foobar', ['2014-01-01 00:00:00'])
        );
    }
}
