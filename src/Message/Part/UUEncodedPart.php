<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Message\Part;

use ZBateson\MailMimeParser\Header\HeaderFactory;

/**
 * A specialized NonMimePart representing a uuencoded part.
 * 
 * This represents part of a message that is not a mime message.  A multi-part
 * mime message may have a part with a Content-Transfer-Encoding of x-uuencode
 * but that would be represented by a normal MimePart.
 * 
 * UUEncodedPart extends NonMimePart to return a Content-Transfer-Encoding of
 * x-uuencode, a Content-Type of application-octet-stream, and a
 * Content-Disposition of 'attachment'.  It also expects a mode and filename to
 * initialize it, and adds 'filename' parts to the Content-Disposition and
 * 'name' to Content-Type.
 * 
 * @author Zaahid Bateson <zbateson@gmail.com>
 */
class UUEncodedPart extends NonMimePart
{
    /**
     * @var int the unix file permission
     */
    protected $mode = null;
    
    /**
     * @var string the name of the file in the uuencoding 'header'.
     */
    protected $filename = null;
    
    /**
     * Initiates the UUEncodedPart with the passed mode and filename.
     * 
     * @param resource $handle
     * @param \ZBateson\MailMimeParser\Message\Part\MimePart $parent
     * @param array $properties
     */
    public function __construct(
        $handle,
        $contentHandle,
        MimePart $parent,
        array $properties
    ) {
        parent::__construct(
            $handle,
            $contentHandle,
            $parent
        );
        if (isset($properties['mode'])) {
            $this->mode = $properties['mode'];
        }
        if (isset($properties['filename'])) {
            $this->filename = $properties['filename'];
        }
    }
    
    /**
     * Returns the file mode included in the uuencoded header for this part.
     * 
     * @return int
     */
    public function getUnixFileMode()
    {
        return $this->mode;
    }
    
    /**
     * Returns the filename included in the uuencoded header for this part.
     * 
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }
    
    /**
     * Returns false.
     * 
     * @return bool
     */
    public function isTextPart()
    {
        return false;
    }
    
    /**
     * Returns text/plain
     * 
     * @return string
     */
    public function getContentType()
    {
        return 'application/octet-stream';
    }
    
    /**
     * Returns 'inline'.
     * 
     * @return string
     */
    public function getContentDisposition()
    {
        return 'attachment';
    }
    
    /**
     * Returns 'x-uuencode'.
     * 
     * @return string
     */
    public function getContentTransferEncoding()
    {
        return 'x-uuencode';
    }
}
