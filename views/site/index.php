<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

$this->title = 'Test task';

$this->registerJs("$(function() {
	$('.phone-numbers').click(function(e) {
		var elementId = $(this).attr('id');
		$('.modal-body').html(elementId);
		$('#modal').modal('show');
	});
});");
?>


<?php if( Yii::$app->session->hasFlash('success') ): ?>
	<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?= Yii::$app->session->getFlash('success'); ?>
	</div>
<?php endif; ?>


<div class="site-index">

    <div class="jumbotron">
        <h1>Clients</h1>
		<p><a class="btn btn-lg btn-success" href="<?= Url::to(['site/update']); ?>">Update Clients from XML</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
<?php
    yii\bootstrap\Modal::begin(['id'=>'modal', 'header'=>'<h2>Номера телефонов</h2>', 'size'=>'modal-md']);
    yii\bootstrap\Modal::end();
?>			
    			
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'cl_id',
            'cl_name',
			'cl_age',
			[
				'attribute' => 'cl_city',
				'value' => 'city.c_name'
			],
			[
				'class' => 'yii\grid\ActionColumn', 
				'template' => '{view}',
				'header' => 'Cl Phones',        
                'buttons' => [
					'view' => function ($url, $model, $key) {						
								$phones = '';
								foreach($model->getPhone()->all() as $p)
									$phones .= $p->p_number.'<br/>';						
								return Html::button('Номера телефонов', ['class' => 'btn btn-success phone-numbers', 'id'=>$phones]);
						}
				],
			],
			
		],
	]); ?>

			    <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
