<?php
/* @var \bbn\mvc\model $model */
if ( 
  !empty($model->data['year']) &&
  !empty($model->data['month']) &&
  ($path = BBN_DATA_PATH.'/hr/planning/'.$model->data['year'].'/'.$model->data['year'].'-'.$model->data['month'].'.json') &&
  is_file($path) &&
  ($f = file_get_contents($path)) &&
  ($data = json_decode($f, true)) &&
  ($type = $model->inc->options->from_code('wp', 'events', 'appui')) &&
  ($events = new \bbn\appui\events($model->db))
){
  foreach ( $data as $d ){
    if ( !$model->db->select_one([
      'table' => 'amiral_planning',
      'fields' => ['amiral_planning.id'],
      'join' => [[
        'table' => 'bbn_events',
        'on' => [
          'conditions' => [[
            'field' => 'amiral_planning.id_event',
            'exp' => 'bbn_events.id'
          ], [
            'field' => 'bbn_events.id_type',
            'value' => $type
          ], [
            'field' => 'DATE(bbn_events.start)',
            'value' => date('Y-m-d', strtotime($d['start']))
          ], [
            'field' => 'DATE(bbn_events.end)',
            'value' => date('Y-m-d', strtotime($d['end']))
          ]]
        ]
      ]],
      'where' => [
        'amiral_planning.id_entity' => $d['id_entity'],
        'amiral_planning.id_employe' => $d['id_employe']
      ]
    ]) ){
      if ( 
        !($id_event = $events->insert([
          'id_type' => $type,
          'start' => $d['start'],
          'end' => $d['end']
        ])) ||
        !$model->db->insert('amiral_planning', [
          'id_employe' => $d['id_employe'],
          'id_entity' => $d['id_entity'],
          'id_event' => $id_event
        ])
      ){
        return [
          'success' => false,
          'error' => 'Error during insert into db.'
        ];
      }
    }
  }
  return ['success' => true];
}
return ['success' => false];