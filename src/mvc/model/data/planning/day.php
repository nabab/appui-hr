<?php
/* @var \bbn\mvc\model $model */
if ( !empty($model->data['day']) ){
  $start = $model->data['day'].' 00:00:00';
  $end = $model->data['day'].' 23:59:59';
  if ( $events = $model->db->rselect_all([
    'table' => 'bbn_events',
    'fields' => [
      'amiral_planning.id',
      'amiral_planning.id_event',
      'bbn_events.start',
      'bbn_events.end',
      'id_employe' => 'bbn_hr_staff.id',
      'amiral_planning.id_entity',
      'entity_nom' => 'amiral_entities.nom',
      'entity_adresse' => 'bbn_addresses.fulladdress'
    ],
    'join' => [[
      'table' => 'amiral_planning',
      'on' => [
        'conditions' => [[
          'field' => 'amiral_planning.id_event',
          'exp' => 'bbn_events.id'
        ]]
      ]
    ], [
      'table' => 'bbn_hr_staff',
      'on' => [
        'conditions' => [[
          'field' => 'amiral_planning.id_employe',
          'exp' => 'bbn_hr_staff.id'
        ]]
      ]
    ], [
      'table' => 'bbn_people',
      'on' => [
        'conditions' => [[
          'field' => 'bbn_people.id',
          'exp' => 'bbn_hr_staff.id'
        ]]
      ]
    ], [
      'table' => 'amiral_entities',
      'on' => [
        'conditions' => [[
          'field' => 'amiral_planning.id_entity',
          'exp' => 'amiral_entities.id'
        ]]
      ]
    ], [
      'table' => 'amiral_liens',
      'on' => [
        'conditions' => [[
          'field' => 'amiral_entities.id',
          'exp' => 'amiral_liens.id_entity'
        ],[
          'field' => 'amiral_liens.type_lien',
          'value' => $model->inc->options->from_code('siege', 'liens')
        ]]
      ]
    ], [
      'table' => 'bbn_addresses',
      'on' => [
        'conditions' => [[
          'field' => 'amiral_liens.id_lieu',
          'exp' => 'bbn_addresses.id'
        ]]
      ]
    ]],
    'where' => [
      'conditions' => [[
        'field' => 'bbn_events.id_type',
        'value' => $model->inc->options->from_code('wp', 'events', 'appui')
      ], [
        'field' => 'bbn_events.start',
        'operator' => '>=',
        'value' => $start
      ], [
        'field' => 'bbn_events.end',
        'operator' => '<=',
        'value' => $end
      ]]
    ],
    'order' => [
      'bbn_people.surname' => 'ASC',
      'bbn_people.name' => 'ASC',
      'entity_nom' => 'ASC',
      'entity_adresse' => 'ASC'
    ]
  ]) ){
    return [
      'data' => $events,
      'json' => false,
      'success' => true
    ];
  }
  else if ( date('Y-m', strtotime($model->data['day'])) < date('Y-m') ){
    return [
      'data' => [],
      'json' => false,
      'success' => true
    ];
  }
  else {
    $year = date('Y', strtotime($model->data['day']));
    $filename = date('Y-m', strtotime($model->data['day'])).'.json';
    $path = $model->data_path('appui-hr')."planning/$year/";
    if ( 
      is_file($path.$filename) && 
      ($d = file_get_contents($path.$filename)) &&
      ($d = json_decode($d, true))
    ){
      $d = array_filter($d, function($e) use($start, $end){
        return ($e['start'] >= $start) && ($e['end'] <= $end);
      });
      return [
        'data' => array_values($d),
        'json' => filemtime($path.$filename),
        'success' => true
      ];
    }
    return ['success' => false]; 
  }
}