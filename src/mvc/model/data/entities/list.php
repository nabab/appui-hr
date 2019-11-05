<?php
$grid = new \bbn\appui\grid($model->db, $model->data, [
  'table' => 'bbn_people',
  'fields' => [
    'amiral_planning.id_employe',
    'bbn_events.start',
    'bbn_events.end',
    'amiral_planning.id_entity',
    'amiral_entities.type_entity',
    'chantier' => 'amiral_entities.nom',
    'chantier_adresse' => 'bbn_addresses.fulladdress',
    'bbn_events.id_type'
  ],
  'join' => [[
    'table' => 'bbn_hr_staff',
    'on' => [
      'conditions' => [[
        'field' => 'bbn_people.id',
        'exp' => 'bbn_hr_staff.id'
      ]]
    ]
  ], [
    'table' => 'bbn_hr_staff_events',
    'on' => [
      'conditions' => [[
        'field' => 'bbn_hr_staff.id',
        'exp' => 'bbn_hr_staff_events.id_employe'
      ]]
    ]
  ], [
    'table' => 'bbn_events',
    'on' => [
      'conditions' => [[
        'field' => 'bbn_events.id',
        'exp' => 'bbn_hr_staff_events.id_event'
      ], [
        'field' => 'bbn_events.end',
        'operator' => '>=',
        'value' => date('Y-m-d H:i:s')
      ]]
    ]
  ], [
    'table' => 'amiral_planning',
    'on' => [
      'conditions' => [[
        'field' => 'bbn_people.id',
        'exp' => 'amiral_planning.id_employe'
      ]]
    ]
  ], [
    'table' => 'bbn_events',
    'alias' => 'ev',
    'on' => [
      'conditions' => [[
        'field' => 'amiral_planning.id_event',
        'exp' => 'ev.id'
      ], [
        'logic' => 'OR',
        'conditions' => [[
          'conditions' => [[
            'field' => 'ev.start',
            'operator' => '>=',
            'exp' => 'bbn_events.start'
          ], [
            'field' => 'ev.start',
            'operator' => '<=',
            'exp' => 'bbn_events.end'
          ]]
        ], [
          'conditions' => [[
            'field' => 'ev.end',
            'operator' => '>=',
            'exp' => 'bbn_events.start'
          ], [
            'field' => 'ev.end',
            'operator' => '<=',
            'exp' => 'bbn_events.end'
          ]]
        ]]
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
        'field' => 'amiral_entities.id',
        'exp' => 'amiral_liens.id_entity'
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
  ], [
    'table' => 'amiral_planning',
    'alias' => 'rplanning',
    'type' => 'left',
    'on' => [
      'conditions' => [[
        'field' => 'rplanning.id_alias',
        'exp' => 'amiral_planning.id'
      ]]
    ]
  ], [
    'table' => 'bbn_events',
    'alias' => 'revents',
    'type' => 'left',
    'on' => [
      'conditions' => [[
        'field' => 'rplanning.id_event',
        'exp' => 'revents.id'
      ]]
    ]
  ], [
    'table' => 'bbn_people',
    'alias' => 'rpeople',
    'type' => 'left',
    'on' => [
      'conditions' => [[
        'field' => 'rplanning.id_employe',
        'exp' => 'rpeople.id'
      ]]
    ]
  ]],
  'filters' => [
    'conditions' => [[
      'field' => 'rplanning.id',
      'operator' => 'isnull'
    ]]
  ],
  'group_by' => ['amiral_planning.id_employe', 'amiral_planning.id_entity']
]);

if ( $grid->check() ){
  return $grid->get_datatable(true);
}
