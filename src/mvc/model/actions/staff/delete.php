<?php
if (
  !empty($model->data['id']) &&
  ($manager = $model->inc->user->getManager()) &&
  ($cfg = $model->inc->user->getClassCfg())
){
  $id_user = $model->db->selectOne('bbn_hr_staff', 'id_user', ['id' => $model->data['id']]);
  if ( $model->db->delete('bbn_hr_staff', ['id' => $model->data['id']]) ) {
    if ( !empty($id_user) ){
      $manager->deactivate($id_user);
    }
    return ['success' => true];
  }
}
return ['success' => false];
