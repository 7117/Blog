<?php
// 命名空间
namespace common\models;

// 使用yii
use Yii;
// 使用html帮助类
use yii\helpers\Html;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $author_id
 *
 * @property Comment[] $comments
 * @property Adminuser $author
 * @property Poststatus $status0
 */
// 模型继承AR类
class Post extends \yii\db\ActiveRecord
{
    private $_oldTags;
    
    /**
     * @inheritdoc
     */
    // 返回表名 就是进行返回了表中的各种属性
    // 针对于post表的属性
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'status', 'author_id'], 'required'],
            [['content', 'tags'], 'string'],
            [['status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['title'], 'string', 'max' => 128],
            // 作者必须存在 作者id必须存在  必须存在于adminuser里面
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Adminuser::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Poststatus::className(), 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    // 属性方法
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'tags' => '标签',
            'status' => '状态',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'author_id' => '作者',
        ];
    }

    // 下面的代码全部是业务逻辑
    // 获得所有的评论
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }
    // 获得激活的评论
    public function getActiveComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id'])
        ->where('status=:status',[':status'=>2])->orderBy('id DESC');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    // 获得作者
    public function getAuthor()
    {
        // 使用adminuser的id获取
        return $this->hasOne(Adminuser::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    // 获得状态
    public function getStatus0()
    {
        return $this->hasOne(Poststatus::className(), ['id' => 'status']);
    }
    // 保存之前
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($insert)
            {
                $this->create_time = time();
                $this->update_time = time();
            }
            else 
            {
                $this->update_time = time();
            }
            
            return true;
                
        }
        else 
        {
            return false;
        }
    } 
    // 在找到之后
    public function afterFind()
    {
        parent::afterFind();
        $this->_oldTags = $this->tags;
    }
    // 在保存之后
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Tag::updateFrequency($this->_oldTags, $this->tags);
    }
    // 在删除之后
    public function afterDelete()
    {
        parent::afterDelete();
        Tag::updateFrequency($this->tags, '');
    }
    // 获得url
    public function getUrl()
    {
        return Yii::$app->urlManager->createUrl(
                ['post/detail','id'=>$this->id,'title'=>$this->title]);
    }
    
    public function getBeginning($length=288)
    {
        $tmpStr = strip_tags($this->content);
        $tmpLen = mb_strlen($tmpStr);
         
        $tmpStr = mb_substr($tmpStr,0,$length,'utf-8');
        return $tmpStr.($tmpLen>$length?'...':'');
    }
    // 获得标签的链接
    public function  getTagLinks()
    {
        $links=array();
        foreach(Tag::string2array($this->tags) as $tag)
        {
            $links[]=Html::a(Html::encode($tag),array('post/index','PostSearch[tags]'=>$tag));
        }
        return $links;
    }
    // 获得评论的数量
    public function getCommentCount()
    {
        return Comment::find()->where(['post_id'=>$this->id,'status'=>2])->count();
    }
}
