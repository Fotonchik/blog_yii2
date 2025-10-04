<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property string|null $role
 * @property string $created_at
 * @property string $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    const ROLE_ADMIN = 'admin';
    const ROLE_AUTHOR = 'author';
    const ROLE_USER = 'user';
    public $avatarFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role'], 'default', 'value' => 'user'],
            [['username', 'email', 'password_hash', 'auth_key'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'email'], 'string', 'max' => 100],
            [['password_hash'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['role'], 'string', 'max' => 20],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['avatar'], 'string', 'max' => 255],
            [['avatarFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 1024 * 1024 * 2, 'checkExtensionByMimeType' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password_hash' => 'Password',
            'auth_key' => 'Auth Key',
            'role' => 'Role',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'avatar' => 'Аватар',
            'avatarFile' => 'Загрузить аватар',

        ];
    }

    // МЕТОДЫ ДЛЯ АУТЕНТИФИКАЦИИ:

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isAuthor()
    {
        return $this->role === self::ROLE_AUTHOR;
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['register'] = ['username', 'email', 'password_hash'];
        return $scenarios;
    }
       public function uploadAvatar()
    {
        if ($this->avatarFile) {
            $avatarsPath = Yii::getAlias('@webroot/uploads/avatars');
            if (!file_exists($avatarsPath)) {
                mkdir($avatarsPath, 0777, true);
            }
            
            // Удаляем старый аватар если есть
            if ($this->avatar && file_exists($avatarsPath . '/' . $this->avatar)) {
                unlink($avatarsPath . '/' . $this->avatar);
            }
            
            // Генерируем уникальное имя файла
            $fileName = 'avatar_' . $this->id . '_' . time() . '.' . $this->avatarFile->extension;
            $filePath = $avatarsPath . '/' . $fileName;
            
            // Сохраняем файл
            if ($this->avatarFile->saveAs($filePath)) {
                $this->avatar = $fileName;
                return true;
            }
        }
        return false;
    }
    public function getAvatarUrl()
    {
        if ($this->avatar) {
            return Yii::getAlias('@web/uploads/avatars/' . $this->avatar);
        }
        // Возвращаем аватар по умолчанию
        return Yii::getAlias('@web/images/efault-avatar.jpg');
    }
    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['author_id' => 'id']);
    }
}