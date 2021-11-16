<?php

namespace App\Helper;

class FileHelper
{
    private static string $dir = __DIR__ . "/../../public/";
    private string $folderName;

    public function __construct()
    {
        $this->setFolderName("documentos");
        $this->createDirectory();
    }

    public function createDirectory(): void
    {
        if(!file_exists(self::$dir . $this->folderName)) {
            @mkdir(self::$dir . $this->folderName, 0777);
        }
    }

    public function deleteFile(string $fileName, string $folderName = "documentos"): void
    {
        if(file_exists(self::$dir . $folderName . "/" . $fileName)) {
            @unlink(self::$dir . $folderName . "/" . $fileName);
        }
    }

    public function setFolderName(string $folderName): void
    {
        $this->folderName = $folderName;
    }

    public function getFolderName(): string
    {
        return $this->folderName;
    }
}