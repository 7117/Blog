<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Post;

/**
 * PostSearch represents the model behind the search form about `common\models\Post`.
 */
class PostSearch extends Post
{
    
    public function attributes()
    {
        return array_merge(parent::attributes(),['authorName']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['title', 'content', 'tags','authorName'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        // GridView主要由以下3部分进行组成
        // 1.dataprovider 2.filterModel 3.columns
        // 返回的是post的所有的文章信息
        $query = Post::find();
        // var_dump($query);die;
        // 对于得到的数据进行添加条件的修改和显示
        // ActiveDataProvider返回的是个对象
        $dataProvider = new ActiveDataProvider([
            // 1.数据传入
            // 2.进行分页
            // 3.进行排序
            'query' => $query,
            'pagination' => ['pageSize'=>3],
            'sort'=>[
                    'defaultOrder'=>[
                            'id'=>SORT_DESC,                    
                    ],
                    'attributes'=>['id','title'],
            ],
        ]);

        // 块赋值
        $this->load($params);

        // 对输入的数据进行验证
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // 是否在错误输入的情况下展示数据
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'post.id' => $this->id,
            'post.status' => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'author_id' => $this->author_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'tags', $this->tags]);

        $query->join('INNER JOIN','Adminuser','post.author_id = Adminuser.id');
        $query->andFilterWhere(['like','Adminuser.nickname',$this->authorName]);
        
        $dataProvider->sort->attributes['authorName'] = 
        [
            'asc'=>['Adminuser.nickname'=>SORT_ASC],
            'desc'=>['Adminuser.nickname'=>SORT_DESC],
        ];
               
        return $dataProvider;
    }
}
