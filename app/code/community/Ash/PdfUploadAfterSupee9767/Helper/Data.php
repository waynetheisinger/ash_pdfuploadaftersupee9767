<?php
/**
 * Ash_PdfUploadAfterSupee9767
 *
 * Fix/allow PDF files to be uploaded via WYSIWYG image upload process
 * after the SUPEE-9767 security patch changed file validation in
 * Mage_Core_Model_File_Validator_Image
 *
 * @see https://stackoverflow.com/a/44828074
 *
 * @category    Ash
 * @package     Ash_PdfUploadAfterSupee9767
 * @copyright   Copyright (c) 2017 August Ash, Inc. (http://www.augustash.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Ash_PdfUploadAfterSupee9767_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ENABLED = 'ash_pdfuploadaftersupee9767/general/enabled';

    /**
     * Check if Ash_PdfUploadAfterSupee9767 is enabled
     *
     * @return  boolean
     */
    public function isEnabled()
    {
        if (Mage::getStoreConfigFlag(self::XML_PATH_ENABLED)) {
            return true;
        }
        return false;
    }

    /**
     * is PDF file
     * @param $filename
     * @return bool
     */
    public function isAllowed($filename){
        $mimeTypeAllowed = 'application/pdf';
        if(function_exists('mime_content_type'))
            $mimeType = mime_content_type($filename);
        else
            $mimeType = $this->_mime_content_type($filename);

        if($mimeType == $mimeTypeAllowed)
            return true;
        else
            return false;
    }

    /**
     * mime_content_type could be undefined
     * @see Uncaught Error: Call to undefined function mime_content_type()
     * @param $filename
     * @return bool|string
     */
    private function _mime_content_type($filename) {
        $result = new finfo();

        if (is_resource($result) === true) {
            return $result->file($filename, FILEINFO_MIME_TYPE);
        }
        return false;
    }
}
