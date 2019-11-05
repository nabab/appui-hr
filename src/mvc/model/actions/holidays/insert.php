<?php
if ( 
  !empty($model->data['start']) &&
  !empty($model->data['end']) &&
  \bbn\str::is_uid($model->data['id_employe']) &&
  \bbn\str::is_uid($model->data['id_type']) &&
  ($events = new \bbn\appui\events($model->db)) &&
  ($id_event = $events->insert([
    'id_type' => $model->data['id_type'],
    'start' => $model->data['start'],
    'end' => $model->data['end']
  ])) &&
  $model->db->insert('bbn_hr_staff_events', [
    'id_employe' => $model->data['id_employe'],
    'id_event' => $id_event,
    'note' => $model->data['note'] ?? NULL
  ])
){
  return ['success' => true];
}
return ['success' => false];