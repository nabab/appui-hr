<?php
if ( 
  !empty($model->data['id']) &&
  ($events = new \bbn\appui\events($model->db))
){
  $ok1 = $events->edit($model->data['id'], $model->data);
  $ok2 = $model->db->update('bbn_hr_staff_events', [
    'note' => $model->data['note'],
    'id_staff' => $model->data['id_staff']
  ], [
    'id_event' => $model->data['id']
  ]);
  if ( !empty($ok1) || !empty($ok2) ){
    return ['success' => true];
  }
}
return ['success' => false];