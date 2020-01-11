<?php

namespace frontend\models;

use frontend\models\UploadForm;

class UploadUrlForm extends UploadForm
{
    
    const DEFAULT_FILE_TYPE = 'jpg';
    
    public $imageUrl;
    private $fileTypes = ['png', 'jpg', 'jpeg'];
    
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
            $this->imagePath = $this->getImageDir($this->dir). $this->imageName . '.' . $this->getImageExtension($this->imageUrl);
            //save image-file from url
            //echo '<pre>';var_dump($this->imagePath);die();
            $this->saveImageFromUrl($this->imageUrl, $this->imagePath);
            //check if file already exist by checksum
            if (!$this->isUniqueCheckSum($this->imagePath)) {
                unlink($this->imagePath);
                \Yii::$app->session->setFlash('error', 'Error -> file already exist');
                return false;
            }
            return true;
        } else {
            \Yii::$app->session->setFlash('error', 'Error -> ' . serialize($this->getErrors()));
            return false;
        }
    }
    
    private function saveImageFromUrl(string $url, string $filePath): bool {
        if (copy($url, $filePath)) {
            return true;
        } else {
            return false;
        }
    }
    
    private function getImageExtension($url) {
        $extension = explode('.', $url);
        $currentExt = array_pop($extension);
        if (in_array($currentExt, $this->fileTypes)) {
            return $currentExt;
        } else {
            return self::DEFAULT_FILE_TYPE;
        }
    }
    
}