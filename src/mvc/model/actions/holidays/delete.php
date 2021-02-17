<?php
if (
  !empty($model->data['id']) &&
  ($events = new \bbn\Appui\Event($model->db)) &&
  ($planning = new \bbn\Appui\Planning($model->db)) &&
  ($event = $events->get($model->data['id'])) &&
  ($id_staff = $model->db->selectOne('bbn_hr_staff_events', 'id_staff', ['id_event' => $model->data['id']]))
){
  $workingdays = $planning->getAll($event['start'], $event['end'], $id_staff);
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
            'value' => date('Y-m-d', strtotime($event['start']))
          ], [
            'field' => 'alias',
            'operator' => '<=',
            'value' => date('Y-m-d', strtotime($event['end']))
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
  if (
    $events->delete($model->data['id']) &&
    $model->db->delete('bbn_hr_staff_events', ['id_event' => $model->data['id']])
  ){
    return ['success' => true];
  }
}
return ['success' => false];