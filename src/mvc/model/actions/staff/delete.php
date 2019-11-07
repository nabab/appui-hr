<?php
if ( 
  !empty($model->data['id']) &&
  ($manager = $model->inc->user->get_manager()) &&
  ($cfg = $model->inc->user->get_class_cfg())
){
  $id_user = $model->db->select_one('bbn_hr_staff', 'id_user', ['id' => $model->data['id']]);
  if ( $model->db->delete('bbn_hr_staff', ['id' => $model->data['id']]) ) {
    if ( !empty($id_user) ){
      $manager->deactivate($id_user);
    }
    return ['success' => true];
  }
}
return ['success' => false];
