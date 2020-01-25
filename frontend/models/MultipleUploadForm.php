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
    
    /**
     * Upload images
     * @return bool
     */
    public function upload(): bool
    {
        if ($this->validate()) {
            foreach ($this->imageFiles as $key => $file) {
                $this->saveCurrentImage($key, $file);
            }
            //echo '<pre>';var_dump($this);
            if (!empty($this->images)) {
                return true;
            }
            
            return false;
        } else {
            \Yii::$app->session->setFlash('error', 'Error -> ' . serialize($this->getErrors()));
            
            return false;
        }
    }
    
    /**
     * Save current image on server
     * @param int $key
     * @param UploadedFile $file
     * @return void
     */
    protected function saveCurrentImage(int $key, UploadedFile $file): void
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
            $this->addImageToStorage($key);
        }
    }
    
    /**
     * Add image to "images" property
     * @param int $key
     * @return void
     */
    protected function addImageToStorage(int $key): void
    {
        $image = new \stdClass();
        $image->imageName = $this->imageName;
        $image->imagePath = $this->imagePath;
        $image->hash = $this->hash;
        
        $this->images[$key] = $image;
    }
    
    /**
     * Save all images data into db
     * @return void
     */
    public function saveCurrentMultipleImages(): void
    {
        foreach ($this->images as $key => $image) {
            $this->imageName = $image->imageName;
            $this->imagePath = $image->imagePath;
            $this->hash = $image->hash;
            $this->imageFile = $this->imageFiles[$key];
            
            $images = new Images();
            $images->saveCurrentImage($this, self::FORM_TYPE_FILE);
        }
    }
    
}