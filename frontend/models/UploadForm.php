<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{

    public $imageFile;
    public $dir = 'images/';
    public $thumbDir = 'thumbnails/';
    public $imagePath;
    public $name;
    public $description;

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Please choose a name.'],
            [['name'], 'string', 'max' => 256],
            [['description'], 'string'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg']
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->imagePath = $this->getImageDir(). $this->getUniqName() . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($this->imagePath);
            return true;
        } else {
            var_dump($this->getErrors());die();
            return false;
        }
    }
    
    /**
     * Пределать на год/месяц/день TODO!!!
     * @return string
     */
    public function getImageDir(): string {
        $date = date('Y_m_d');
        $currentAbsoluteDir = \Yii::getAlias('@webroot') . '/' . $this->dir . $date;
        $currentDir = $this->dir . $date. '/';
        if (!file_exists($currentAbsoluteDir)) {
            mkdir($currentAbsoluteDir);
        }
        return $currentDir;
    }
    
    private function getUniqName(): string {
        return uniqid();
    }
    
    public function getImageParams(string $image): array {
         $rawData = getimagesize($image);
         return [
             'width' => $rawData[0],
             'hight' => $rawData[1]
         ];
    }
    
    
    public function makeThumbnail() {
        
    }
}