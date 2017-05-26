<?php


namespace Tests\Infrastructure\ValueObject\Web;


use Infrastructure\ValueObject\Locale\LanguageCode;
use Infrastructure\ValueObject\Web\Url;
use Tests\Infrastructure\Base;

class UrlTest extends Base
{
    public function testSanity()
    {
        $rawUrl = 'http://www.mobials.com:9000/a/?a=b#fragment';
        $url = new Url($rawUrl);

        $this->assertEquals($rawUrl, $url->getURL());
        $this->assertEquals('a=b', $url->getQuery());
        $this->assertEquals('http', $url->getScheme());
        $this->assertEquals(9000, $url->getPort());
        $this->assertEquals('/a/', $url->getPath());
        $this->assertEquals('fragment', $url->getFragment());
        $this->assertEquals('www.mobials.com', $url->getHost());

        $this->assertEquals($rawUrl, $url->__toString());
    }

    public function testEquals()
    {
        $rawUrl = 'http://www.mobials.com:9000/a/?a=b#fragment';
        $url = new Url($rawUrl);

        $url2 = new Url($rawUrl);

        $rawUrl3 = 'http://www.mobials.com:9001/a/?a=b#fragment';
        $url3 = new Url($rawUrl3);


        $this->assertTrue($url->equals($url2));
        $this->assertTrue(!$url->equals($url3));
        $this->assertTrue(!$url2->equals($url3));
        $this->assertTrue(!$url->equals(LanguageCode::EN()));
    }

    public function testSerialization()
    {
        $rawUrl = 'http://www.mobials.com:9000/a/?a=b#fragment';
        $url = new Url($rawUrl);

        $array = $url->jsonSerialize();
        $url2 = Url::deserialize($array);

        $this->assertTrue($url->equals($url2));
    }
}