<?php
namespace backend\models;

use yii\base\Model;
use backend\models\Images;
use frontend\models\ImagesTags;
use frontend\models\Tags;
use frontend\models\Descriptions;

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
        $transaction = \Yii::$app->db->beginTransaction();
        try
        {
            //update image
            $image = Images::findOne(['id' => $id]);
            $image->name = $this->name;
            $image->source = $this->source;
            $image->translit_name = $this->translit_name;
            $image->update();
            //update tags
            ImagesTags::deleteAll(['image_id' => $id]);
            $tagsModel = new Tags();
            $tagsModel->saveImageTags($this->tags, $id);
            //IF ONLY IMAGE CHANGE - UPDATE!!!!
            //update description
            if (isset($this->description) && !empty($this->description)) {
                $descModel = Descriptions::find()->where(['image_id' => $id])->one();
                $descModel->text = $this->description;
                $descModel->update();
            }
            $transaction->commit();
            return true;
        } catch(Exception $e) {
           $transaction->rollBack();
           return false;
        }
    }
    
}
