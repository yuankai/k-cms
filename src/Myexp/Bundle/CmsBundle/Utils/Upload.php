<?php

namespace Myexp\Bundle\CmsBundle\Helper;

class Upload {

    public static function genFileName() {
        return sha1(uniqid(mt_rand(), true));
    }

    public static function getSavePath($path = null) {

        $hash_path = self::getHashPath($path);

        return $path === null ? null : self::getUploadRootDir() . $hash_path;
    }

    public static function getWebPath($path = null) {
        return self::getUploadDir() . '/' . self::getHashPath($path) . $path;
    }

    public static function getDownloadWebPath($path = null) {
        return self::getDownloadDir() . '/' . $path;
    }

    private static function getHashPath($path = null) {
        return $path === null ? null : $path[0] . $path[1] . '/' . $path[2] . $path[3] . '/';
    }

    private static function getUploadRootDir() {
        return __DIR__ . '/../../../../web/' . self::getUploadDir() . '/';
    }

    private static function getUploadDir() {
        return 'media/original';
    }

    public static function getDownloadPath($path = null) {

        //$hash_path = self::getHashPath($path);

        return $path === null ? null : self::getDownloadRootDir();
    }

    private static function getDownloadRootDir() {
        return __DIR__ . '/../../../../web/' . self::getDownloadDir() . '/';
    }

    private static function getDownloadDir() {
        return 'upload/download';
    }

}
