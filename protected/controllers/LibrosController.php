<?php

class LibrosController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		
	
		$model=new Libros;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Libros']))
		
		{
			//print_r($_POST);
			$model->attributes=$_POST['Libros'];
			$model->setRelationRecords('autors',is_array(@$_POST['Autores']) ? $_POST['Autores'] : array());
			$model->setRelationRecords('autors',is_array(@$_POST['Libros']['autors']) ? $_POST['Libros']['autors'] : array());
			
			if(isset($_POST['addautor'])) $model->addAutor();
			if(isset($_POST['deleteautor'])) $model->deleteAutor($_POST['idx']);
			if(!isset($_POST['addautor']) && !isset($_POST['deleteautor'])) 
			{
				if($model->save())
					$this->redirect(array('view','id'=>$model->id));
			}
			
			
		}

		$this->render('create',array(
			'model'=>$model,
		));
	
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Libros']))
		{
			
			
			$model->attributes=$_POST['Libros'];
			$model->setRelationRecords('autors',is_array(@$_POST['Autores']) ? $_POST['Autores'] : array());
			$model->setRelationRecords('autors',is_array(@$_POST['Libros']['autors']) ? $_POST['Libros']['autors'] : array());
			
						
			if(isset($_POST['addautor'])) $model->addAutor();
			if(isset($_POST['deleteautor'])) $model->deleteAutor($_POST['idx']);
			if(!isset($_POST['addautor']) && !isset($_POST['deleteautor'])) 
			{
				if($model->save())
					$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
		$c=$this->loadModel($id);
		$numRefs = Copias::model()->count('libros_id=:librosid',array(':librosid'=>$c->id));
		if($numRefs==0)
			{
				$c->delete();
			} else
			{
				throw new CHttpException(400,'Existen copias de este libro. No puede ser borrado.');
			}	
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Libros');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Libros('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Libros']))
			$model->attributes=$_GET['Libros'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Libros the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Libros::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Libros $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='libros-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
