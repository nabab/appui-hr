<?php
/* @var \bbn\mvc\model $model */
if ( 
  !empty($model->data['day']) &&
  !empty($model->data['id_employe']) &&
  !empty($model->data['id_entity']) &&
  !empty($model->data['hour'])
){
  $h = floor($model->data['hour']);
  $m = ($model->data['hour'] - $h) === 0.5 ? 30 : 0;
  $start = $model->data['day'].' 08:00:00';
  $end = new DateTime($start);
  $end->add(new DateInterval('PT'.$h.'H'.$m.'M'));
  $end = $end->format('Y-m-d H:i:s');
  if ( empty($model->data['toJSON']) ){
    if ( 
      $model->db->insert('bbn_events', [
        'start' => $start,
        'end' => $end,
        'id_type' => $model->inc->options->from_code('wp', 'events', 'appui')
      ]) &&
      ($id_event = $model->db->last_id()) &&
      $model->db->insert('amiral_planning', [
        'id_event' => $id_event,
        'id_employe' => $model->data['id_employe'],
        'id_entity' => $model->data['id_entity']
      ])
    ){
      return [
        'json' => false,
        'success' => true
      ];
    }
  }
  else {
    $year = date('Y', strtotime($model->data['day']));
    $filename = date('Y-m', strtotime($model->data['day'])).'.json';
    $path = BBN_DATA_PATH."/hr/planning/$year/";
    if ( 
      is_file($path.$filename) && 
      ($d = file_get_contents($path.$filename)) &&
      ($d = json_decode($d, true))
    ){
      
      $entity = $model->db->rselect([
        'table' => 'amiral_entities',
        'fields' => [
          'amiral_entities.nom',
          'bbn_addresses.fulladdress'
        ],
        'join' => [[
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
          'amiral_entities.id' => $model->data['id_entity']
        ]
      ]);
      $d[] = [
        'id' => \bbn\x::make_uid(),
        'start' => $start,
        'end' => $end,
        'id_employe' => $model->data['id_employe'],
        'id_entity' => $model->data['id_entity'],
        'entity_nom' => $entity['nom'],
        'entity_adresse' => $entity['fulladdress']
      ];
      if ( file_put_contents($path.$filename, json_encode($d)) && is_file($path.$filename) ){
        return [
          'json' => filemtime($path.$filename),
          'success' => true
        ];
      }
    }
  }
}
return ['success' => false]; 