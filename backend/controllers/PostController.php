<?php

namespace backend\controllers;

// 这里全部的都进行了引用
use Yii;
// 控制器肯定会引用模型相关的文件
use common\models\Post;
use common\models\PostSearch;
// 控制器都需要引用的类
use yii\web\Controller;
// 没有找到需要引用的类
use yii\web\NotFoundHttpException;
// 使用behavior的时候需要引入的文件 动作过滤类
use yii\filters\VerbFilter;
// 拒绝请求的时候发送信息需要引用的类
use yii\web\ForbiddenHttpException;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
     */
    // behavior起到过滤数据的作用
    // 1.可以过滤用户
    // 2.可以过滤动作提交的方式
    public function behaviors()
    {
        return [
            //1.设置access
            //2.动作的设置
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    // 删除只允许的提交方式是post 否则报错
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    // 首页动作 列表动作 
    // 这里面就集成了一个查询的功能
    // 首页里面的操作
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        // dataprovider会把进行查询到的数据进行排序分页等操作
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // 进行显示到index的页面
        return $this->render('index', [
            // 搜索到的结果进行显示到首页
            'searchModel' => $searchModel,
            // 搜索到的数据进行提供给dataprovider
            'dataProvider' => $dataProvider,
        ]);
    }

// 以下是增删改查的代码vcud(view create update delete)
// -----------------------------------------------------------------------------

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    // 查看一篇文章的代码 由url的id参数传递进来后  进行actionview显示
    public function actionView($id)
    {
        // 第一种查询的方法：yii/db/command
        // 命令createCommand
        // $post=Yii::$app->db->createCommand('select * from post
        //     where id=:id and status=:status')
        // // 绑定参数
        // ->bindValue(':id',$_GET['id'])
        // ->bindValue(':status',2)
        // ->queryOne();
        // var_dump($post);
        // die;
        // render方法：view是作为模板 model方法返回的是数据
        // 
        // 第二种查询的方法：方法find
        // $model=Post::find()->where(['id'=>32])->one();
        // $model=Post::find()->where(['status'=>1])->all();
        // 
        // 
        // 
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // 新增一篇文章
    public function actionCreate()
    {

        // 查看用户是否有创建文章的权限
        if(!Yii::$app->user->can('createPost')){
            // 如果没有权限的话 就使用ForbiddenHttpException跳出相关的信息
            throw new ForbiddenHttpException("对不起,你没有进行操作的权限");
        }

        // 新建一个对象
        $model = new Post();

        // $model->create_time=time();
        // $model->update_time=time();
        // 加载输入的数据
        // 进行保存输入的数据
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // 创建成功 就跳转到相关的展示页面
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            // 如果没有创建成功的话 就进行跳转到创建页面
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    // 修改
    public function actionUpdate($id)
    {
        
        if(!Yii::$app->user->can('updatePost')){
            throw new ForbiddenHttpException("对不起,你没有进行操作的权限");
        }


        $model = $this->findModel($id);
        // 先查看1、是否有数据提交上来  2.查看是否符合数据规则 如符合则进行保存       
        // $model->update_time=time();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // 跳转到文章查看页面
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            // 继续显示修改页面 并提示错误
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    // 删除
    public function actionDelete($id)
    {
        
        if(!Yii::$app->user->can('deletePost')){
            throw new ForbiddenHttpException("对不起,你没有进行操作的权限");
        }


        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

// -----------------------------------------------------------------------------

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // 查找字段的操作
    // 修饰符为protected 表示这个方法只允许类里面的方法进行调用
    protected function findModel($id)
    {
        // ($model = Post::findOne($id)
        // 关键点findOne是AR已经定义好的方法
        // 
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
