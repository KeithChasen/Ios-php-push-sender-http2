<?php
namespace Phpushios;

use PhpushiosException;

class Message
{
    /**
     * apple aps namespace
     */
    const APS_NAMESPACE = 'aps';
    /**
     * @var string
     */
    protected $payloadData;

    /**
     * @var integer
     */
    protected $badgeNum;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $sound;

    /**
     * @var integer
     */
    protected $contentAvailable;

    /**
     * @var string
     */
    protected $category;

    /**
     * @var integer
     */
    protected $mutableContent;

    /**
     * @var array
     */
    protected $customProperties;

    /**
     * Sets and returns payload
     *
     * @return string
     */
    public function setPayload()
    {
        $this->payloadData = [self::APS_NAMESPACE => []];
        if (isset($this->text)) {
            $this->payloadData[self::APS_NAMESPACE ]['alert'] = $this->text;
        }
        if (isset($this->sound)) {
            $this->payloadData[self::APS_NAMESPACE ]['sound'] = $this->sound;
        }
        if (isset($this->badgeNum)) {
            $this->payloadData[self::APS_NAMESPACE ]['badge'] = $this->badgeNum;
        }
        if (isset($this->contentAvailable)) {
            $this->payloadData[self::APS_NAMESPACE ]['content-available'] = $this->contentAvailable;
        }
        if (isset($this->category)) {
            $this->payloadData[self::APS_NAMESPACE ]['category'] = $this->category;
        }
        if (isset($this->mutableContent)) {
            $this->payloadData[self::APS_NAMESPACE ]['mutable-content'] = $this->mutableContent;
        }

        if (!empty($this->customProperties)) {
            foreach ($this->customProperties as $key => $value) {
                $this->payloadData[self::APS_NAMESPACE][$key] = $value;
            }
        }

        $this->payloadData = json_encode($this->payloadData);

        return $this->payloadData;
    }

    /**
     * Sets the value of badge
     *
     * @param integer $number
     * @throws PhpushiosException
     */
    public function setBadgeNumber($number)
    {
        if (!is_int($number) && $number >= 0) {
            throw new PhpushiosException(
                "Invalid badge number " . $number
            );
        }
        $this->badgeNum = $number;
    }

    /**
     * Sets content-available parameter to configure silent push
     *
     * @param bool $contentAvailable
     * @throws PhpushiosException
     */
    public function setContentAvailable($contentAvailable = false)
    {
        if (!is_bool($contentAvailable)) {
            throw new PhpushiosException(
                "Invalid content-available value " . $contentAvailable
            );
        }
        $this->contentAvailable = $contentAvailable ? (int)$contentAvailable : null;
    }

    /**
     * Sets category
     *
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = !empty($category) ? $category : null;
    }

    /**
     * Sets mutable-content key for extension on iOS10
     *
     * @param bool $mutableContent
     * @throws PhpushiosException
     */
    public function setMutableContent($mutableContent = false)
    {
        if (!is_bool($mutableContent)) {
            throw new PhpushiosException(
                "Invalid mutable-content value " . $mutableContent
            );
        }
        $this->mutableContent = $mutableContent ? (int)$mutableContent : null;
    }

    /**
     * Sets alert message
     *
     * @param string $message
     */
    public function setAlert($message)
    {
        $this->text = $message;
    }

    /**
     * Sets sound
     *
     * @param string $sound
     */
    public function setSound($sound)
    {
        $this->sound = $sound;
    }

    /**
     * Sets custom property
     *
     * @param string $name
     * @param string $value
     *
     * @throws PhpushiosException
     */
    public function setCustomProperty($name, $value)
    {
        if (trim($name) == self::APS_NAMESPACE) {
            throw new PhpushiosException(
                'Property ' . $name . ' can not be used'
            );
        }
        $this->customProperties[$name] = $value;
    }
}
