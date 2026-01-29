<?php

namespace app\services;

use Yii;
use yii\web\UploadedFile;

class FileService
{
    private $uploadPath;
    private $webPath;

    public function __construct()
    {
        $this->uploadPath = Yii::getAlias('@webroot/uploads/books');
        $this->webPath = '/uploads/books';
        
        if (!file_exists($this->uploadPath)) {
            mkdir($this->uploadPath, 0755, true);
        }
    }

    /**
     * Загружает файл и возвращает путь относительно web
     * @param UploadedFile $file
     * @param string|null $oldFile Путь к старому файлу для удаления
     * @return string|null Путь к файлу или null при ошибке
     */
    public function upload(UploadedFile $file, $oldFile = null)
    {
        if (!$file || $file->hasError) {
            return null;
        }

        $extension = $file->extension;
        $fileName = uniqid('book_', true) . '.' . $extension;
        $filePath = $this->uploadPath . '/' . $fileName;

        if ($file->saveAs($filePath)) {
            if ($oldFile) {
                $this->delete($oldFile);
            }
            
            return $this->webPath . '/' . $fileName;
        }

        return null;
    }

    /**
     * Удаляет файл
     * @param string $filePath Путь относительно web
     * @return bool
     */
    public function delete($filePath)
    {
        if (empty($filePath)) {
            return false;
        }

        $relativePath = str_replace($this->webPath . '/', '', $filePath);
        $fullPath = $this->uploadPath . '/' . $relativePath;

        if (file_exists($fullPath) && is_file($fullPath)) {
            return @unlink($fullPath);
        }

        return false;
    }

    /**
     * Валидирует файл изображения
     * @param UploadedFile $file
     * @return bool
     */
    public function validateImage(UploadedFile $file)
    {
        if (!$file || $file->hasError) {
            return false;
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        $extension = strtolower($file->extension);
        $mimeType = $file->type;

        return in_array($extension, $allowedExtensions) 
            && in_array($mimeType, $allowedMimeTypes)
            && $file->size <= 5 * 1024 * 1024;
    }
}

