<?php
/* @var \bbn\mvc\model $model */
if ( !empty($model->data['data']['start']) && !empty($model->data['data']['end']) ){
  $id_staff = null;
  if ( 
    !empty($model->data['filters']) &&
    !empty($model->data['filters']['conditions']) &&
    (($idx = \bbn\x::find($model->data['filters']['conditions'], ['field' => 'id_staff'])) !== false)
  ){
    $id_staff = $model->data['filters']['conditions'][$idx]['value'];
  }
  $pla = new \bbn\appui\planning($model->db);
  return [
    'data' => $pla->get_all(
      $model->data['data']['start'],
      $model->data['data']['end'],
      $id_staff
    ),
    'success' => true
  ];
}
return ['success' => false];