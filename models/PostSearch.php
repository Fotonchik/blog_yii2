<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PostSearch represents the model behind the search form of `app\models\Post`.
 */
class PostSearch extends Model
{
    public $id;
    public $title;
    public $content;
    public $author_id;
    public $created_at;
    public $search; // Общее поле поиска

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'author_id'], 'integer'],
            [['title', 'content', 'created_at', 'search'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'search' => 'Поиск',
            'author_id' => 'Автор',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * Creates data provider instance with search query applied
     */
    public function search($params)
    {
        $query = Post::find()->joinWith(['author']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 9,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
                'attributes' => [
                    'title',
                    'created_at',
                    'author_id' => [
                        'asc' => ['users.username' => SORT_ASC],  
                        'desc' => ['users.username' => SORT_DESC], 
                    ],
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Общий поиск по заголовку и содержанию
        if (!empty($this->search)) {
            $query->andWhere(['or',
                ['like', 'posts.title', $this->search],        
                ['like', 'posts.content', $this->search],      
                ['like', 'users.username', $this->search]      
            ]);
        }

        // Фильтрация по автору
        if (!empty($this->author_id)) {
            $query->andWhere(['posts.author_id' => $this->author_id]); 
        }

        // Фильтрация по дате
        if (!empty($this->created_at)) {
            $query->andWhere(['DATE(posts.created_at)' => $this->created_at]); 
        }

        return $dataProvider;
    }
}