<?php

namespace frontend\models;

use frontend\models\UploadForm;

class UploadUrlForm extends UploadForm
{
    
    const DEFAULT_FILE_TYPE = 'jpg';
    
    private $fileTypes = ['png', 'jpg', 'jpeg'];
    public $imageUrl;
    
    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Please choose a name.'],
            [['name'], 'string', 'max' => 255],
            [['imageUrl'], 'required', 'message' => 'Please input url.'],
            [['imageUrl'], 'string', 'min' => 10],
            [['description', 'source', 'status'], 'string'],
            [['hash'], 'unique', 'targetClass' => 'frontend\models\Images'],
            [['tags'], 'required', 'message' => 'Please choose a tags.']
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->imageName = $this->getUniqName();
            $this->imageExtension = $this->getImageExtension($this->imageUrl);
            $this->imagePath = $this->getImageDir($this->dir). $this->imageName . '.' . $this->imageExtension;
            //save image-file from url
            if ($this->saveImageFromUrl($this->imageUrl, $this->imagePath)) {
                //check if file already exist by checksum
                if (!$this->isUniqueCheckSum($this->imagePath)) {
                    unlink($this->imagePath);
                    \Yii::$app->session->addFlash('error', "Error -> file [$this->imageUrl] already exist");
                    return false;
                }
            } else {
                return false;
            }
            return true;
        } else {
            \Yii::$app->session->addFlash('error', 'Error -> ' . serialize($this->getErrors()));
            return false;
        }
    }
    
    private function saveImageFromUrl(string $url, string $filePath): bool {
        try {
            if (copy($url, $filePath)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            \Yii::$app->session->addFlash('error', 'Error -> ' . $e->getMessage());
            return false;
        }  
    }
    
    private function getImageExtension(string $url): string {
        $extension = explode('.', $url);
        $currentExt = array_pop($extension);
        if (in_array($currentExt, $this->fileTypes)) {
            return $currentExt;
        } else {
            return self::DEFAULT_FILE_TYPE;
        }
    }
    
}