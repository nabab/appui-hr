<?php
if ( 
  !empty($model->data['id_entity']) &&
  !empty($model->data['events']) &&
  ($events = new \bbn\Appui\Event($model->db)) &&
  ($id_type = $model->inc->options->fromCode('wp', 'event', 'appui'))
){
  $success = false;
  foreach ( $model->data['events'] as $ev ){
    if ( empty($ev['holiday_id']) ){
      if ( 
        !empty($ev['start']) &&
        !empty($ev['end']) &&
        !empty($ev['id_employe']) &&
        isset($ev['id_planning']) &&
        (
          ($id_event = $events->insert([
            'start' => $ev['start'],
            'end' => $ev['end'],
            'id_type' => $id_type
          ])) &&
          $model->db->insert('amiral_planning', [
            'id_employe' => $ev['id_employe'],
            'id_entity' => $model->data['id_entity'],
            'id_event' => $id_event,
            'id_alias' => $ev['id_planning'] ?: NULL
          ])
        )
      ){
        $success = true;
      }
      else {
        $success = false;
        break;
      }
    }
  }
  return ['success' => $success];
}
else if (
  !empty($model->data['id_entity']) &&
  !empty($model->data['id_employe']) &&
  !empty($model->data['id_old_employe']) &&
  !empty($model->data['start']) &&
  !empty($model->data['end']) &&
  ($model->data['id_employe'] !== $model->data['id_old_employe']) &&
  ($list = $model->getModel('data/hr/entities/planning', [
    'id_entity' => $model->data['id_entity'],
    'id_employe' => $model->data['id_old_employe']
  ])) &&
  !empty($list['data']) &&
  ($events = new \bbn\Appui\Event($model->db)) &&
  ($id_type = $model->inc->options->fromCode('wp', 'event', 'appui'))
) {
  $success = false;
  foreach ( $list['data'] as $ev ){
    if ( 
      !empty($ev['start']) &&
      !empty($ev['end']) &&
      !empty($ev['id_planning']) &&
      ($ev['start'] >= $model->data['start']) &&
      ($ev['end'] <= $model->data['end']) &&
      (
        ($id_event = $events->insert([
          'start' => $ev['start'],
          'end' => $ev['end'],
          'id_type' => $id_type
        ])) &&
        $model->db->insert('amiral_planning', [
          'id_employe' => $model->data['id_employe'],
          'id_entity' => $model->data['id_entity'],
          'id_event' => $id_event,
          'id_alias' => $ev['id_planning']
        ])
      )
    ){
      $success = true;
    }
    else {
      $success = false;
      break;
    }
  }
  return ['success' => $success];
}
return ['success' => false];