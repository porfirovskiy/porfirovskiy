<?php
namespace backend\models;

use yii\base\Model;
use backend\models\Images;

class ImageUpdateForm extends Model
{
    public $name;
    public $source;
    public $description;
    public $tags;
    public $translit_name;

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Please choose a name.'],
            [['name', 'translit_name'], 'string', 'max' => 255],
            [['description', 'source'], 'string'],
            [['tags'], 'required', 'message' => 'Please choose a tags.']
        ];
    }
    
    public function update(int $id): bool
    {
        //update image
        $image = Images::find()->where(['id' => $id]);
        $image->name = $this->name;
        $image->source = $this->source;
        $image->translit_name = $this->translit_name;
        $image->update();
        //update tags
        
        //update description
        if (isset($this->description) && !empty($this->description)) {
            $descModel = Descriptions::find()->where(['image_id' => $id]);;
            $descModel->text = $this->description;
            $descModel->update();
        }
        
        
        echo '<pre>';var_dump($model);die();
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
