<?php


namespace Tests\Infrastructure\ValueObject\Web;


use Infrastructure\ValueObject\Locale\LanguageCode;
use Infrastructure\ValueObject\Web\Attachment;
use Tests\Infrastructure\Base;

class AttachmentTest extends Base
{
    public function testConstructor() {
        $attachment = new Attachment('a', 'b', 'c');

        $this->assertEquals('a', $attachment->getName());
        $this->assertEquals('b', $attachment->getContent());
        $this->assertEquals('c', $attachment->getMimeType());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidConstructor() {
        $attachment = new Attachment('','','');
    }

    public function testEquals() {
        $attachment = new Attachment('a', 'b', 'c');

        $attachment2 = new Attachment('a', 'b', 'c');

        $attachment3 = new Attachment('a', 'b', 'd');

        $this->assertTrue($attachment->equals($attachment2));

        $this->assertTrue(!$attachment2->equals(LanguageCode::EN()));

        $this->assertTrue(!$attachment2->equals($attachment3));
    }

    public function testToString() {
        $attachment = new Attachment('a', 'b', 'c');
        $this->assertEmpty($attachment->__toString());
    }
}