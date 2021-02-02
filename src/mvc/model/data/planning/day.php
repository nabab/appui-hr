<?php
/* @var \bbn\Mvc\Model $model */
if ( !empty($model->data['day']) ){
  $planning = new \bbn\Appui\Planning($model->db);
  $id_staff = null;
  if ( 
    !empty($model->data['filters']) &&
    !empty($model->data['filters']['conditions']) &&
    (($idx = \bbn\X::find($model->data['filters']['conditions'], ['field' => 'id_staff'])) !== null)
  ){
    $id_staff = $model->data['filters']['conditions'][$idx]['value'];
  }
  return [
    'success' => true,
    'data' => $planning->getAll($model->data['day'].' 00:00:00', $model->data['day'].' 23:59:59', $id_staff)
  ];
}