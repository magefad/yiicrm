<?php

/** @noinspection PhpUndefinedClassInspection */
class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
}