<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;
use frontend\models\Images;

class UploadForm extends Model
{

    public $imageFile;
    public $dir = 'images/';
    public $thumbDir = 'thumbnails/';
    public $imagePath;
    public $imageName;
    public $name;
    public $source;
    public $description;
    public $tags;
    public $hash;

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Please choose a name.'],
            [['name'], 'string', 'max' => 255],
            [['description', 'source'], 'string'],
            [['hash'], 'unique', 'targetClass' => 'frontend\models\Images'],
            [['tags'], 'required', 'message' => 'Please choose a tags.'],
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
    
    private function isUniqueCheckSum($imageName) {
        $this->hash = sha1_file($imageName);
        $count = (int)Images::find()->where(['hash' => $this->hash])->count();
        if ($count > 0) {
            return false;
        }
        return true;
    }
    
}