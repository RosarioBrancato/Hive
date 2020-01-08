<?php


namespace Util;


class FileUtils
{

    public static function GetMimeFromFilename(string $filename)
    {
        $mime = "";

        $extention = pathinfo(strtolower($filename), PATHINFO_EXTENSION);

        switch ($extention) {
            case "txt":
                $mime = "text/plain";
                break;
            case "pdf":
                $mime = "application/pdf";
                break;
            case "png":
                $mime = "image/png";
                break;
            case "apng":
                $mime = "image/apng";
                break;
            case "bmp":
                $mime = "image/bmp";
                break;
            case "gif":
                $mime = "image/gif";
                break;
            case "jpg":
            case "jpeg":
            case "jfif":
            case "pjpeg":
            case "pjp":
                $mime = "image/jpeg";
                break;
            case "svg":
                $mime = "image/svg+xml";
                break;
        }

        return $mime;
    }

}