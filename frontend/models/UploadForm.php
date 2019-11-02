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
     * год/месяц/день
     * Пример images/2019/11/02
     * @return string
     */
    public function getImageDir(): string {
        $absoluteDirYear = \Yii::getAlias('@webroot') . '/' . $this->dir . date('Y');
        $absoluteDirMonth = $absoluteDirYear . '/' . date('m');
        $absoluteDirDay = $absoluteDirMonth . '/' . date('d');
        $currentDir = $this->dir . date('Y'). '/' . date('m'). '/' . date('d') . '/';
        if (!file_exists($absoluteDirYear)) {
            mkdir($absoluteDirYear);
            mkdir($absoluteDirMonth);
            mkdir($absoluteDirDay);
        } elseif (!file_exists($absoluteDirMonth)) {
            mkdir($absoluteDirMonth);
            mkdir($absoluteDirDay);
        } elseif (!file_exists($absoluteDirDay)) {
            mkdir($absoluteDirDay);
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