<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hiject\Helper;

use Hiject\Core\Base;

/**
 * File helpers
 */
class FileHelper extends Base
{
    /**
     * Get file icon
     *
     * @access public
     * @param  string   $filename   Filename
     * @return string               Font-Awesome-Icon-Name
     */
    public function icon($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        switch ($extension) {
            case 'jpeg':
            case 'jpg':
            case 'png':
            case 'gif':
                return 'fa-file-image-o';
            case 'xls':
            case 'xlsx':
                return 'fa-file-excel-o';
            case 'doc':
            case 'docx':
                return 'fa-file-word-o';
            case 'ppt':
            case 'pptx':
                return 'fa-file-powerpoint-o';
            case 'zip':
            case 'rar':
            case 'tar':
            case 'bz2':
            case 'xz':
            case 'gz':
                return 'fa-file-archive-o';
            case 'mp3':
                return 'fa-file-audio-o';
            case 'avi':
            case 'mov':
                return 'fa-file-video-o';
            case 'php':
            case 'html':
            case 'css':
                return 'fa-file-code-o';
            case 'pdf':
                return 'fa-file-pdf-o';
        }

        return 'fa-file-o';
    }

    /**
     * Return the image mimetype based on the file extension
     *
     * @access public
     * @param  $filename
     * @return string
     */
    public function getImageMimeType($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                return 'image/jpeg';
            case 'png':
                return 'image/png';
            case 'gif':
                return 'image/gif';
            default:
                return 'image/jpeg';
        }
    }

    /**
     * Get the preview type
     *
     * @access public
     * @param  string $filename
     * @return string
     */
    public function getPreviewType($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        switch ($extension) {
            case 'md':
            case 'markdown':
                return 'markdown';
            case 'txt':
                return 'text';
        }

        return null;
    }
}
