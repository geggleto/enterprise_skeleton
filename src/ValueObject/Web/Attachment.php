<?php
namespace Infrastructure\ValueObject\Web;

use Infrastructure\ValueObject\ValueObject;
use InvalidArgumentException;


class Attachment implements ValueObject
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $mimeType;

    /**
     * @param string $name
     * @param string $content base64 encoded content
     * @param string $mimeType the mimetype
     */
    public function __construct($name, $content, $mimeType)
    {
        if (empty($name) || empty($mimeType)) {
            throw new \InvalidArgumentException("All fields required");
        }

        //why the hell would we ever
        //decode the entire body ???!
//        if (\is_string($name) === false)
//        {
//            throw new InvalidArgumentException('Attachment name must be a string');
//        }

//        if (base64_decode($content, true) === false)
//        {
//             throw new InvalidArgumentException('Content must be base64 encoded');
//        }

//        if (\is_string($mimeType) === false)
//        {
//            throw new InvalidArgumentException('Mime type must be a string');
//        }

        $this->name = $name;
        $this->content = $content;
        $this->mimeType = $mimeType;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '';
    }

    /**
     * @inheritdoc
     *
*@param Attachment|ValueObject $object
     *
     * @return bool
     */
    public function equals(ValueObject $object)
    {
        if ($object instanceof Attachment === false)
        {
            return false;
        }

        if ($this->getName() === $object->getName()
        && $this->getContent() === $object->getContent()
        && $this->getMimeType() === $object->getMimeType())
        {
            return true;
        }

        return false;
    }
}