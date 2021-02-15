<?php
if (
  !empty($model->data['id_staff']) &&
  !empty($model->data['id_event']) &&
  $model->db->update('bbn_hr_staff_events', ['status' => 'refused'], [
    'id_staff' => $model->data['id_staff'],
    'id_event' => $model->data['id_event']
  ]) &&
  ($planning = new \bbn\Appui\Planning($model->db))
){
  $event = $model->db->select('bbn_events', [], ['id' => $model->data['id_event']]);
  $workingdays = $planning->getAll($event->start, $event->end, $model->data['id_staff']);
  $substitutes = [];
  foreach ( $workingdays as $wd ){
    if ( !isset($substitutes[$wd['id']]) ){
      $substitutes[$wd['id']] = $model->db->selectAll([
        'table' => 'bbn_hr_planning',
        'fields' => [],
        'where' => [
          'conditions' => [[
            'field' => 'id_alias',
            'value' => $wd['id']
          ], [
            'field' => 'alias',
            'operator' => '>=',
            'value' => date('Y-m-d', strtotime($event->start))
          ], [
            'field' => 'alias',
            'operator' => '<=',
            'value' => date('Y-m-d', strtotime($event->end))
          ]]
        ]
      ]);
    }
  }
  foreach ( $substitutes as $subs ){
    foreach ( $subs as $sub ){
      $planning->delete($sub->id);
    }
  }
  return ['success' => true];
}
return ['success' => false];