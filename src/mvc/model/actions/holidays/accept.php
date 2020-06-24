<?php
if (
  !empty($model->data['id_staff']) &&
  !empty($model->data['id_event']) &&
  $model->db->update('bbn_hr_staff_events', ['status' => 'accepted'], [
    'id_staff' => $model->data['id_staff'],
    'id_event' => $model->data['id_event']
  ])
){
  return ['success' => true];
}
return ['success' => false];