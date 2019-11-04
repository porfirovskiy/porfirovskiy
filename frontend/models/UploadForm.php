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
    public $imageName;
    public $name;
    public $description;

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Please choose a name.'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string'],
            [
                ['imageFile'],
                'file',
                'skipOnEmpty' => false,
                'extensions' => 'png, jpg',
                'maxSize' => 1024*1024*12
            ]
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->imageName = $this->getUniqName();
            $this->imagePath = $this->getImageDir($this->dir). $this->imageName . '.' . $this->imageFile->extension;
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
    public function getImageDir(string $dir): string {
        $absoluteDirYear = \Yii::getAlias('@webroot') . '/' . $dir . date('Y');
        $absoluteDirMonth = $absoluteDirYear . '/' . date('m');
        $absoluteDirDay = $absoluteDirMonth . '/' . date('d');
        $currentDir = $dir . date('Y'). '/' . date('m'). '/' . date('d') . '/';
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
        return bin2hex(random_bytes(10));
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