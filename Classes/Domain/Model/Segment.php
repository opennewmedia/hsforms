<?php
namespace Onm\Hsforms\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;

/***
 *
 * This file is part of the "hsForms" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Usman Ahmad <ua@onm.de>, ONM GmbH
 *
 ***/
/**
 * Segment
 */
class Segment extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * code
     *
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $code = '';

    /**
     * internalName
     *
     * @var string
     */
    protected $internalName = '';

    /**
     * title
     *
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $title = '';

    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $image = null;

    /**
     * Returns the code
     *
     * @return string $code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets the code
     *
     * @param string $code
     * @return void
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        $this->image = $image;
    }

    /**
     * Get internalName
     *
     * @return  string
     */
    public function getInternalName()
    {
        return $this->internalName;
    }

    /**
     * Set internalName
     *
     * @param  string  $internalName  internalName
     *
     * @return  self
     */
    public function setInternalName(string $internalName)
    {
        $this->internalName = $internalName;

        return $this;
    }
}
