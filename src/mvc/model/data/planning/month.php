<?php
/* @var bbn\Mvc\Model $model */
if ( !empty($model->data['data']['start']) && !empty($model->data['data']['end']) ){
  $id_staff = null;
  if ( 
    !empty($model->data['filters']) &&
    !empty($model->data['filters']['conditions']) &&
    (($idx = \bbn\X::search($model->data['filters']['conditions'], ['field' => 'id_staff'])) !== null)
  ){
    $id_staff = $model->data['filters']['conditions'][$idx]['value'];
  }
  $pla = new \bbn\Appui\Planning($model->db);
  return [
    'data' => $pla->getAll(
      $model->data['data']['start'],
      $model->data['data']['end'],
      $id_staff
    ),
    'success' => true
  ];
}
return ['success' => false];