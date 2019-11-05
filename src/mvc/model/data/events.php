<?php
/* @var \bbn\mvc\model $model */
if ( !empty($model->data['data']) ){
  $model->data = $model->data['data'];
}
$where = [];
$employe_filter = [
  'field' => 'bbn_hr_staff_events.id_employe',
  'value' => $model->data['employe']
];

if ( !empty($model->data['day']) ){
  $where = [
    'conditions' => [[
      'field' => 'bbn_events.start',
      'operator' => '<=',
      'value' => $model->data['day']
    ], [
      'field' => 'bbn_events.end',
      'operator' => '>=',
      'value' => $model->data['day']
    ]]
  ];
  if ( !empty($model->data['employe']) ){
    $where['conditions'][] = $employe_filter;
  }
}
else if ( !empty($model->data['week']) && !empty($model->data['start']) && !empty($model->data['end']) ){
  $where = [
    'logic' => 'OR',
    'conditions' => [[
      'logic' => 'AND',
      'conditions' => [[
        'field' => 'bbn_events.start',
        'operator' => '>=',
        'value' => $model->data['start']
      ], [
        'field' => 'bbn_events.end',
        'operator' => '<=',
        'value' => $model->data['end']
      ]]
    ], [
      'logic' => 'AND',
      'conditions' => [[
        'field' => 'bbn_events.start',
        'operator' => '>=',
        'value' => $model->data['start']
      ], [
        'field' => 'bbn_events.end',
        'operator' => '>=',
        'value' => $model->data['end']
      ]]
    ], [
      'logic' => 'AND',
      'conditions' => [[
        'field' => 'bbn_events.start',
        'operator' => '<=',
        'value' => $model->data['start']
      ], [
        'logic' => 'OR',
        'conditions' => [[
          'conditions' => [[
            'field' => 'bbn_events.end',
            'operator' => '<=',
            'value' => $model->data['end']
          ], [
            'field' => 'bbn_events.end',
            'operator' => '>=',
            'value' => $model->data['start']
          ]]
        ], [
          'conditions' => [[
            'field' => 'bbn_events.end',
            'operator' => '>=',
            'value' => $model->data['end']
          ]]
        ]]
      ]]
    ]]
  ]; 
  if ( !empty($model->data['employe']) ){
    $where['conditions'][0]['conditions'][] = $employe_filter;
    $where['conditions'][1]['conditions'][] = $employe_filter;
    $where['conditions'][2]['conditions'][] = $employe_filter;
  }
}
else if ( empty($model->data['week']) && !empty($model->data['start']) && !empty($model->data['end']) ){
  $args = [
    $model->data['start'],
    $model->data['end'],
    $model->data['start'],
    $model->data['end'],  
  ];
  if ( !empty($model->data['employe']) ){
    $args[] = hex2bin($model->data['employe']);
  }
  return [
    'data' => $model->db->get_rows("
      SELECT bbn_events.id, bbn_events.id_type, bbn_events.`start`, bbn_events.`end`,
        bbn_hr_staff_events.id_employe, bbn_hr_staff_events.note, bbn_people.fullname AS employe
      FROM bbn_events
        JOIN bbn_hr_staff_events
          ON bbn_hr_staff_events.id_event = bbn_events.id
        JOIN bbn_hr_staff
          ON bbn_hr_staff.id = bbn_hr_staff_events.id_employe
        JOIN bbn_people
          ON bbn_people.id = bbn_hr_staff.id
        JOIN bbn_history_uids AS h1
          ON h1.bbn_uid = bbn_events.id
          AND h1.bbn_active = 1
        JOIN bbn_history_uids AS h2
          ON h2.bbn_uid = bbn_people.id
          AND h2.bbn_active = 1
      WHERE ((bbn_events.`start` BETWEEN ? AND ?) 
        OR (bbn_events.`end` BETWEEN ? AND ?))".
        (!empty($model->data['employe']) ? " AND bbn_hr_staff.id = ?" : ''),
      ...$args
    )
  ];
}

if ( !empty($where) ){
  return [
    'data' => $model->db->rselect_all([
      'table' => 'bbn_events',
      'fields' => [
        'bbn_events.id',
        'bbn_events.id_type',
        'bbn_events.start',
        'bbn_events.end',
        'bbn_hr_staff_events.id_employe',
        'bbn_hr_staff_events.note',
        'employe' => 'bbn_people.fullname'
      ],
      'join' => [[
        'table' => 'bbn_hr_staff_events',
        'on' => [
          'conditions' => [[
            'field' => 'bbn_hr_staff_events.id_event',
            'exp' => 'bbn_events.id'
          ]]
        ]
      ], [
        'table' => 'bbn_hr_staff',
        'on' => [
          'conditions' => [[
            'field' => 'bbn_hr_staff_events.id_employe',
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
      ]],
      'where' => $where
    ])
  ];
}