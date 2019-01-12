<?php

namespace backend\controllers;

// 基本的控制器
use Yii;
use common\models\Adminuser;
use common\models\AdminuserSearch;
// 基本的控制器
use yii\web\Controller;
use yii\web\NotFoundHttpException;
// NotFoundHttpException表示一个状态代码404的“未找到”HTTP异常。
use yii\filters\VerbFilter;
// 用户相关的模型
use backend\models\SignupForm;
use backend\models\ResetpwdForm;
use common\models\AuthItem;
use common\models\AuthAssignment;

/**
 * AdminuserController implements the CRUD actions for Adminuser model.
 */
class AdminuserController extends Controller
{
    /**
     * @inheritdoc
     */
    // 这个函数来配置控制器的权限
    public function behaviors()
    {
        return [
            'verbs' => [
                // 过滤器
                'class' => VerbFilter::className(),
                'actions' => [
                    // 删除的method 只允许的提交方式是post 否则报错
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Adminuser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminuserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Adminuser model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        // context环境  上下文
        // public string render($view, $params = [], $context = null)
        // 第一个参数：视图文件的名字  
        // 第二个参数：查询到的数据
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Adminuser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * 
     * @return mixed
     */

    public function actionCreate()
    {
        // 调取模型
        $model = new SignupForm();
        // 如果执行成功 就转去用户信息查看页面
        if ($model->load(Yii::$app->request->post())) {
           if($user = $model->signup())
           {
           		return $this->redirect(['view', 'id' => $user->id]);
           }    	
        } 
       
        return $this->render('create', [
                'model' => $model,
            ]);
        
    }

    /**
     * Updates an existing Adminuser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Adminuser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Adminuser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 寻找基于给定值（主键值）的adminuser模型  如果模型不存在  就返回一个404
     * @param integer $id
     * @return Adminuser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        // ActiveRecord方法有两个快捷方法：
        // findOne 和 findAll，可以来替换find方法。
        if (($model = Adminuser::findOne($id)) !== null) {
            return $model;
        } else {
            // 封装的好
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionResetpwd($id)
    {
    	$model = new ResetpwdForm();
    
    	if ($model->load(Yii::$app->request->post())) {
    		
    		if($model->resetPassword($id))
    		{
    			return $this->redirect(['index']);
    		}
    	}
    	 
    	return $this->render('resetpwd', [
    			'model' => $model,
    	]);
    
    }
    
    public function actionPrivilege($id)
    {
    	//step1. 找出所有权限,提供给checkboxlist
    	$allPrivileges = AuthItem::find()->select(['name','description'])
    	->where(['type'=>1])->orderBy('description')->all();
    	 
    	foreach ($allPrivileges as $pri)
    	{
    		$allPrivilegesArray[$pri->name]=$pri->description;
    	}
    	//step2. 当前用户的权限
    	 
    	$AuthAssignments=AuthAssignment::find()->select(['item_name'])
    	->where(['user_id'=>$id])->orderBy('item_name')->all();
    	 
    	$AuthAssignmentsArray = array();
    	 
    	foreach ($AuthAssignments as $AuthAssignment)
    	{
    		array_push($AuthAssignmentsArray,$AuthAssignment->item_name);
    	}
    	 
    	//step3. 从表单提交的数据,来更新AuthAssignment表,从而用户的角色发生变化
    	if(isset($_POST['newPri']))
    	{
    		AuthAssignment::deleteAll('user_id=:id',[':id'=>$id]);
    
    		$newPri = $_POST['newPri'];
    
    		$arrlength = count($newPri);
    
    		for($x=0;$x<$arrlength;$x++)
    		{
    		$aPri = new AuthAssignment();
    		$aPri->item_name = $newPri[$x];
    		$aPri->user_id = $id;
    		$aPri->created_at = time();
    		 
    		$aPri->save();
    		}
    		return $this->redirect(['index']);
    	}
    	 
    	//step4. 渲染checkBoxList表单
    
    			return $this->render('privilege',['id'=>$id,'AuthAssignmentArray'=>$AuthAssignmentsArray,
    			'allPrivilegesArray'=>$allPrivilegesArray]);
       			 
    }

}
