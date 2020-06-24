<?php
if (
  !empty($model->data['id']) &&
  ($events = new \bbn\appui\events($model->db)) &&
  ($event = $events->get($model->data['id'])) &&
  ($id_staff = $model->db->select_one('bbn_hr_staff_events', 'id_staff', ['id_event' => $model->data['id']])) &&
  ($planning = new \bbn\appui\planning($model->db))
){
  $dates_to_remove = [];
  $staff_changed = $id_staff !== $model->data['id_staff'];
  if ( !$staff_changed && (($event['start'] !== $model->data['start']) || ($event['end'] !== $model->data['end'])) ){
    $date = date('Y-m-d', strtotime($event['start']));
    $end = date('Y-m-d', strtotime($event['end']));
    while ( $date <= $end ){
      if (
        ($date < date('Y-m-d', strtotime($model->data['start']))) ||
        ($date > date('Y-m-d', strtotime($model->data['end'])))
      ){
        $dates_to_remove[] = $date;
      }
      $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
    }
  }
  if ( !empty($dates_to_remove) || $staff_changed ){
    $workingdays = $planning->get_all($event['start'], $event['end'], $id_staff);
    $substitutes = [];
    foreach ( $workingdays as $wd ){
      if ( !isset($substitutes[$wd['id']]) ){
        $substitutes[$wd['id']] = $model->db->select_all([
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
        if ( in_array($sub->alias, $dates_to_remove) || $staff_changed ){
          $planning->delete($sub->id);
        }
      }
    }
  }
  $ok1 = $events->edit($model->data['id'], $model->data);
  $ok2 = $model->db->update('bbn_hr_staff_events', [
    'note' => $model->data['note'],
    'id_staff' => $model->data['id_staff'],
    'status' => $model->data['status'] ?? NULL
  ], [
    'id_event' => $model->data['id']
  ]);
  if ( !empty($ok1) || !empty($ok2) ){
    return ['success' => true];
  }
}
return ['success' => false];