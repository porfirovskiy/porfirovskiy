<?php

namespace frontend\models;

use frontend\models\UploadForm;
use yii\web\UploadedFile;

class MultipleUploadForm extends UploadForm
{
    
    const DELIMITER_LEVEL = 1;
    
    public $imageFiles;
    public $images = [];
    public $delimiter = '';
    public $endPart = '';




    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Please choose a name.'],
            [['name'], 'string', 'max' => 255],
            [['description', 'source', 'status', 'delimiter', 'endPart'], 'string'],
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
            \Yii::$app->session->addFlash('error', "Error -> file [$file->baseName.$file->extension] already exist");
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
        $number = 1;
        $beginPartOfName = $this->name;
        foreach ($this->images as $key => $image) {
            $this->name = $beginPartOfName . $this->getEndPartOfName($number);
            $this->imageName = $image->imageName;
            $this->imagePath = $image->imagePath;
            $this->hash = $image->hash;
            $this->imageFile = $this->imageFiles[$key];
            
            $images = new Images();
            $images->saveCurrentImage($this, self::FORM_TYPE_FILE);
            
            $number++;
        }
    }
    
    /**
     * Get end part to name by delimiter and number
     * @param int $number
     * @return string
     */
    protected function getEndPartOfName(int $number): string 
    {
        if ($number > self::DELIMITER_LEVEL && !empty($this->delimiter) && !empty($this->endPart)) {
            return $this->delimiter . ' ' . $this->endPart . ' ' . $number;
        }
        return '';
    }
    
}