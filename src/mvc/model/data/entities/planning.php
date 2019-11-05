<?php
if ( !empty($model->data['id_entity']) && !empty($model->data['id_employe']) ){
  if ( $res = $model->db->rselect_all([
    'table' => 'bbn_hr_staff_events',
    'fields' => [
      'ev.start',
      'ev.end',
      'id_planning' => 'amiral_planning.id',
      'holiday_id' => 'bbn_events.id',
      'holiday_start' => 'bbn_events.start',
      'holiday_end' => 'bbn_events.end',
      'bbn_hr_staff_events.id_employe'
    ],
    'join' => [[
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
          'field' => 'bbn_hr_staff_events.id_employe',
          'exp' => 'amiral_planning.id_employe'
        ], [
          'field' => 'amiral_planning.id_entity',
          'value' => $model->data['id_entity']
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
    ]],
    'where' => [
      'conditions' => [[
        'field' => 'bbn_hr_staff_events.id_employe',
        'value' => $model->data['id_employe']
      ]]
    ]
  ]) ){
    $res = array_filter($res, function($r) use($model){
      return empty($model->db->rselect_all([
        'table' => 'amiral_planning',
        'join' => [[
          'table' => 'bbn_events',
          'on' => [
            'conditions' => [[
              'field' => 'amiral_planning.id_event',
              'exp' => 'bbn_events.id'
            ]]
          ]
        ], [
          'table' => 'bbn_people',
          'on' => [
            'conditions' => [[
              'field' => 'amiral_planning.id_employe',
              'exp' => 'bbn_people.id'
            ]]
          ]
        ]],
        'where' => [
          'conditions' => [[
            'field' => 'amiral_planning.id_alias',
            'value' => $r['id_planning']
          ], [
            'field' => 'amiral_planning.id_employe',
            'operator' => '!=',
            'value' => $r['id_employe']
          ]]
        ]
      ]));
    });
    return [
      'data' => array_values($res)
    ];
  }
  
}