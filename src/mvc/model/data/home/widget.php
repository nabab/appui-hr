<?php
/* @var \bbn\mvc\model $model */
if ( !empty($model->data['code']) ){
  return $model->get_plugin_model('home/'. $model->data['code'], $model->data);
}