<?php
use Eris\Generator;
use Eris\Antecedent as is;
use Eris\Antecedent as are;

class CharacterTest extends PHPUnit_Framework_TestCase
{
    use Eris\TestTrait;

    public function setUp()
    {
        $this->minimumEvaluationRatio = 0.2;
    }

    public function testLengthOfAsciiCharactersInPhp()
    {
        $this->forAll([
            Generator\char(['basic-latin']),
        ])
            ->then(function($char) {
                $this->assertLenghtIs1($char);
            });
    }

    public function testLengthOfPrintableAsciiCharacters()
    {
        $this->forAll([
            Generator\char(['basic-latin']),
        ])
            ->when(is\printableCharacter())
            ->then(function($char) {
                $this->assertFalse(ord($char) < 32);
            });
    }

    public function testMultiplePrintableCharacters()
    {
        $this->forAll([
            Generator\char(['basic-latin']),
            Generator\char(['basic-latin']),
        ])
            ->when(are\printableCharacters())
            ->then(function($first, $second) {
                $this->assertFalse(ord($first) < 32);
                $this->assertFalse(ord($second) < 32);
            });
    }

    // TODO: printableCharacter*s*()

    private function assertLenghtIs1($char)
    {
        $length = strlen($char);
        $this->assertEquals(
            1,
            $length,
            "'$char' is too long: $length"
        );
    }
}
