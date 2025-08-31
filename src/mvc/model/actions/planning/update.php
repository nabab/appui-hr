<?php
/* @var bbn\Mvc\Model $model */
if ( 
  !empty($model->data['day']) &&
  !empty($model->data['id']) &&
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
    if ( !empty($model->data['id_event']) ){
      $ok1 = $model->db->update('bbn_events', [
        'start' => $start,
        'end' => $end
      ], [
        'id' => $model->data['id_event']
      ]);
      $ok2 = $model->db->update('amiral_planning', [
        'id_employe' => $model->data['id_employe'],
        'id_entity' => $model->data['id_entity']
      ], [
        'id' => $model->data['id']
      ]);
      if ( !empty($ok1) || !empty($ok2) ){
        return [
          'json' => false,
          'success' => true
        ];
      }
    }
  }
  else {
    $year = date('Y', strtotime($model->data['day']));
    $filename = date('Y-m', strtotime($model->data['day'])).'.json';
    $path = BBN_DATA_PATH."/hr/planning/$year/";
    if ( 
      is_file($path.$filename) && 
      ($d = file_get_contents($path.$filename)) &&
      ($d = json_decode($d, true)) &&
      (($idx = \bbn\X::search($d, ['id' => $model->data['id']])) !== null)
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
              'value' => $model->inc->options->fromCode('siege', 'liens')
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
      $d[$idx] = [
        'id' => $model->data['id'],
        'start' => $start,
        'end' => $end,
        'id_employe' => $model->data['id_employe'],
        'id_entity' => $model->data['id_entity'],
        'entity_nom' => $entity['nom'],
        'entity_adresse' => $entity['fulladdress']
      ];
      if ( file_put_contents($path.$filename, Json_encode($d)) && is_file($path.$filename) ){
        return [
          'json' => filemtime($path.$filename),
          'success' => true
        ];
      }
    }
  }
}
return ['success' => false]; 