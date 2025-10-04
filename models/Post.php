<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $author_id
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $status
 * @property string|null $image
 *
 * @property User $author
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['author_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 1024 * 1024 * 2],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'content' => 'Содержание',
            'author_id' => 'Автор',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'status' => 'Статус',
            'image' => 'Изображение',
            'imageFile' => 'Загрузить изображение',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * Проверяет, может ли пользователь редактировать пост
     */
    public function canEdit($user_id = null)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        
        if ($user_id === null) {
            $user_id = Yii::$app->user->id;
        }
        
        // Админ может редактировать все посты
        $user = User::findOne($user_id);
        if ($user && $user->isAdmin()) {
            return true;
        }
        
        // Автор может редактировать свои посты
        return $this->author_id == $user_id;
    }

    /**
     * Перед сохранением устанавливаем автора
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord && !Yii::$app->user->isGuest) {
                $this->author_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }

    /**
     * Загружает изображение
     */
    public function upload()
    {
        if ($this->validate() && $this->imageFile) {
            $uploadsPath = Yii::getAlias('@webroot/uploads');
            if (!file_exists($uploadsPath)) {
                mkdir($uploadsPath, 0777, true);
            }
            
            $fileName = Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
            $filePath = $uploadsPath . '/' . $fileName;
            
            if ($this->imageFile->saveAs($filePath)) {
                $this->image = $fileName;
                return true;
            }
        }
        return false;
    }
}