<?php
namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;
use frontend\models\Images;

class ImageUpdateForm extends Model
{
    public $name;
    public $source;
    public $description;
    public $tags;

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Please choose a name.'],
            [['name'], 'string', 'max' => 255],
            [['description', 'source'], 'string'],
            [['tags'], 'required', 'message' => 'Please choose a tags.']
        ];
    }
    
    public function update()
    {
        $this->hash = sha1_file($this->imageFile->tempName);
        if ($this->validate()) {
            $this->imageName = $this->getUniqName();
            $this->imagePath = $this->getImageDir($this->dir). $this->imageName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($this->imagePath);
            return true;
        } else {
            \Yii::$app->session->setFlash('error', 'Error -> ' . serialize($this->getErrors()));
            return false;
        }
    }
    
}
