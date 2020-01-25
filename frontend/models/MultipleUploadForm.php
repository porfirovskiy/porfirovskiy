<?php

namespace frontend\models;

use frontend\models\UploadForm;
use yii\web\UploadedFile;

class MultipleUploadForm extends UploadForm
{
    
    public $imageFiles;
    public $images = [];
    
    
    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Please choose a name.'],
            [['name'], 'string', 'max' => 255],
            [['description', 'source', 'status'], 'string'],
            [['hash'], 'unique', 'targetClass' => 'frontend\models\Images'],
            [['tags'], 'required', 'message' => 'Please choose a tags.'],
            [
                ['imageFiles'],
                'file',
                'skipOnEmpty' => false,
                'extensions' => 'png, jpg, jpeg',
                'maxSize' => 1024*1024*12,
                'maxFiles' => 5
            ]
        ];
    }
    
    public function upload(): bool
    {
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $this->saveCurrentImage($file);
            }
            
            if (!empty($this->images)) {
                return true;
            }
            
            return false;
        } else {
            \Yii::$app->session->setFlash('error', 'Error -> ' . serialize($this->getErrors()));
            
            return false;
        }
    }
    
    protected function saveCurrentImage(UploadedFile $file): void
    {
        $this->imageName = $this->getUniqName();
        $this->imageExtension = $file->extension;
        $this->imagePath = $this->getImageDir($this->dir). $this->imageName . '.' . $this->imageExtension;

        $file->saveAs($this->imagePath);
        //check if file already exist by checksum
        if (!$this->isUniqueCheckSum($this->imagePath)) {
            unlink($this->imagePath);
            \Yii::$app->session->setFlash('error', 'Error -> file already exist');
        } else {
            $this->addImageToStorage();
        }
    }
    
    protected function addImageToStorage(): void
    {
        $image = new \stdClass();
        $image->imageName = $this->imageName;
        $image->imageExtension = $this->imageExtension;
        $image->imagePath = $this->imagePath;
        
        $this->images[] = $image;
        
    }
    
}