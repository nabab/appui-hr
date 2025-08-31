<?php
/* @var bbn\Mvc\Model $model */
if ( !empty($model->data['code']) ){
  return $model->getPluginModel('home/'. $model->data['code'], $model->data);
}