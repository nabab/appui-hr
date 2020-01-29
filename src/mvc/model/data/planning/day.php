<?php
/* @var \bbn\mvc\model $model */
if ( !empty($model->data['day']) ){
  $planning = new \bbn\appui\planning($model->db);
  $id_staff = null;
  if ( 
    !empty($model->data['filters']) &&
    !empty($model->data['filters']['conditions']) &&
    (($idx = \bbn\x::find($model->data['filters']['conditions'], ['field' => 'id_staff'])) !== false)
  ){
    $id_staff = $model->data['filters']['conditions'][$idx]['value'];
  }
  return [
    'success' => true,
    'data' => $planning->get_all($model->data['day'].' 00:00:00', $model->data['day'].' 23:59:59', $id_staff)
  ];
}