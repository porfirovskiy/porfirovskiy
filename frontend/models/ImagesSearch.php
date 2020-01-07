<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\models;

//use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Images;

class ImagesSearch extends Images
{
    public function rules()
    {
        // только поля определенные в rules() будут доступны для поиска
        return [
            [['name'], 'required', 'message' => \Yii::t('common', 'Input search request')],
            [['status'], 'string']
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Images::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // изменяем запрос добавляя в его фильтрацию
        $query->filterWhere(['like', 'name', $this->name]);
        $query->andfilterWhere(['in', 'status', Images::getCurrentStatusValues()]);

        return $dataProvider;
    }
}