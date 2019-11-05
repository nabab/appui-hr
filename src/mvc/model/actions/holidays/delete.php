<?php
if ( 
  !empty($model->data['id']) &&
  ($events = new \bbn\appui\events($model->db)) &&
  $events->delete($model->data['id']) &&
  $model->db->delete('bbn_hr_staff_events', ['id_event' => $model->data['id']])
){
  return ['success' => true];
}
return ['success' => false];