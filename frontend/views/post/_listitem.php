<?php
use yii\helpers\Html;
?>

<div class="post">
	<div class="title">
		<!-- 标题 -->
		<h2><a href="<?= $model->url;?>"><?= Html::encode($model->title);?></a></h2>
	
		<div class="author">
		<!-- 创建时间 -->
		<span class="glyphicon glyphicon-time" aria-hidden="true"></span><em><?= date('Y-m-d H:i:s',$model->create_time)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";?></em>
		<!-- 昵称 -->
		<span class="glyphicon glyphicon-user" aria-hidden="true"></span><em><?= Html::encode($model->author->nickname);?></em>
		</div>
	</div>
	
	<br>
	<div class="content">
	<!-- 获得的简写的显示 -->
	<?= $model->beginning;?>	
	</div>
	
	<br>
	<div class="nav">
		<span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
		<!-- 标签的显示 -->
		<?= implode(', ',$model->tagLinks);?>
		<br>
		<!-- 评论的显示 修改的时间-->
		<?= Html::a("评论 ({$model->commentCount})",$model->url.'#comments')?> | 最后修改于 <?= date('Y-m-s H:i:s',$model->update_time);?>
	</div>
	
</div>