<?php
/* @var \bbn\mvc\model $model */

$grid = new \bbn\appui\grid($model->db, $model->data, [
  'table' => 'amiral_planning',
  'fields' => [
    'bbn_events.start',
    'bbn_events.end',
    'id_entity' => 'amiral_entities.id',
    'amiral_entities.nom',
    'amiral_entities.type_entity',
    'bbn_addresses.fulladdress',
    'hour' => 'CONCAT(FLOOR(TIMESTAMPDIFF(MINUTE, bbn_events.start, bbn_events.end)/60), ".", IF(MOD(TIMESTAMPDIFF(MINUTE, bbn_events.start, bbn_events.end), 60) = 30, 5, 0))'
  ],
  'join' => [[
    'table' => 'bbn_events',
    'on' => [
      'conditions' => [[
        'field' => 'bbn_events.id',
        'exp' => 'amiral_planning.id_event'
      ], [
        'field' => 'bbn_events.id_type',
        'value' => $model->inc->options->from_code('wp', 'events', 'appui')
      ]]
    ]
  ], [
    'table' => 'amiral_entities',
    'on' => [
      'conditions' => [[
        'field' => 'amiral_entities.id',
        'exp' => 'amiral_planning.id_entity'
      ]]
    ]
  ], [
    'table' => 'amiral_liens',
    'on' => [
      'conditions' => [[
        'field' => 'amiral_liens.id_entity',
        'exp' => 'amiral_entities.id'
      ], [
        'field' => 'amiral_liens.type_lien',
        'value' => $model->inc->options->from_code('siege', 'liens')
      ]]
    ]
  ], [
    'table' => 'bbn_addresses',
    'on' => [
      'conditions' => [[
        'field' => 'bbn_addresses.id',
        'exp' => 'amiral_liens.id_lieu'
      ]]
    ]
  ]],
  'filters' => [
    'conditions' => [[
      'field' => 'amiral_planning.id_employe',
      'value' => $model->data['data']['id_employe']
    ]]
  ]
]);
if ( $grid->check() ){
  return $grid->get_datatable(true);
}