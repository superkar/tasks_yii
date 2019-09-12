<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property string $title
 * @property int $priority 1 - low, 2 - mid, 3 - high
 * @property int $status 1 - in work, 2 - comleted
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 * @property TaskHasTag[] $taskHasTags
 */
class Task extends \yii\db\ActiveRecord
{
    public $tags;
    
    const PRIORITY_LOW = 1;
    const PRIORITY_MID = 2;
    const PRIORITY_HIGH = 3;
    
    const STATUS_IN_WORK = 1;
    const STATUS_COMPLETED = 2;
    
    protected $priorityRu = [
        self::PRIORITY_LOW => 'Низкий',
        self::PRIORITY_MID => 'Средний',
        self::PRIORITY_HIGH => 'Высокий',
    ];
    
    protected $statusRu = [
        self::STATUS_IN_WORK => 'В работе',
        self::STATUS_COMPLETED => 'Завершена',
    ];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'user_id', 'title', 'priority', 'status', 'tags'], 'required'],
            [['user_id', 'priority', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['uuid'], 'string', 'max' => 36],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['tags'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uuid' => 'UUID',
            'user_id' => 'Пользователь',
            'title' => 'Название',
            'priority' => 'Приоритет',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'tags' => 'Тэги',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskHasTags()
    {
        return $this->hasMany(TaskHasTag::className(), ['task_id' => 'id']);
    }
    
    public function getPriorityRuList()
    {
        return $this->priorityRu;
    }
    
    public function getStatusRuList()
    {
        return $this->statusRu;
    }
    
    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->uuid = $this->genUuidv4(openssl_random_pseudo_bytes(16));
        }
        
        return parent::beforeValidate();
    }
    
    protected function genUuidv4($data)
    {
        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    
    public function getPriorityRu()
    {
        return $this->priorityRu[$this->priority];
    }
    
    public function getStatusRu()
    {
        return $this->statusRu[$this->status];
    }
    
    public function getTagsList()
    {
        $tags = [];
        foreach ($this->taskHasTags as $tag) {
            $tags[] = $tag->tag->title;
        }
        
        return implode(', ', $tags);
    }
}
