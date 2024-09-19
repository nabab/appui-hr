<?php
/* @var \bbn\Mvc\Model $model */
if (
  !empty($model->data['filters']) &&
  !empty($model->data['filters']['conditions'])
){
  if ( ($idx = \bbn\X::find($model->data['filters']['conditions'], ['field' => 'id_staff'])) !== null ){
    $model->data['data']['staff'] = $model->data['filters']['conditions'][$idx]['value'];
  }
  if ( ($idx = \bbn\X::find($model->data['filters']['conditions'], ['field' => 'status'])) !== null ){
    $model->data['data']['status'] = $model->data['filters']['conditions'][$idx]['value'];
  }
}
if ( !empty($model->data['data']) ){
  $model->data = $model->data['data'];
}
$where = [];
if ( !empty($model->data['staff']) ){
  $staff_filter = [
    'field' => 'bbn_hr_staff_events.id_staff',
    'value' => $model->data['staff']
  ];
}
if ( !empty($model->data['status']) ){
  $status_filter = [
    'field' => 'bbn_hr_staff_events.status',
    'value' => $model->data['status']
  ];
}

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
  if ( !empty($model->data['staff']) ){
    $where['conditions'][] = $staff_filter;
  }
  if ( !empty($model->data['status']) ){
    $where['conditions'][] = $status_filter;
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
  if ( !empty($model->data['staff']) ){
    $where['conditions'][0]['conditions'][] = $staff_filter;
    $where['conditions'][1]['conditions'][] = $staff_filter;
    $where['conditions'][2]['conditions'][] = $staff_filter;
  }
  if ( !empty($model->data['status']) ){
    $where['conditions'][0]['conditions'][] = $status_filter;
    $where['conditions'][1]['conditions'][] = $status_filter;
    $where['conditions'][2]['conditions'][] = $status_filter;
  }
}
else if ( empty($model->data['week']) && !empty($model->data['start']) && !empty($model->data['end']) ){
  $args = [
    $model->data['start'],
    $model->data['end'],
    $model->data['start'],
    $model->data['end']
  ];
  if ( !empty($model->data['staff']) ){
    $args[] = hex2bin($model->data['staff']);
  }
  if ( !empty($model->data['status']) ){
    $args[] = $model->data['status'];
  }
  return [
    'data' => $model->db->getRows("
      SELECT bbn_events.id, bbn_events.id_type, bbn_events.`start`, bbn_events.`end`,
        bbn_hr_staff_events.id_staff, bbn_hr_staff_events.note, bbn_hr_staff_events.status, bbn_identities.fullname AS staff
      FROM bbn_events
        JOIN bbn_hr_staff_events
          ON bbn_hr_staff_events.id_event = bbn_events.id
        JOIN bbn_hr_staff
          ON bbn_hr_staff.id = bbn_hr_staff_events.id_staff
        JOIN bbn_identities
          ON bbn_identities.id = bbn_hr_staff.id
        JOIN bbn_history_uids AS h1
          ON h1.bbn_uid = bbn_events.id
          AND h1.bbn_active = 1
        JOIN bbn_history_uids AS h2
          ON h2.bbn_uid = bbn_identities.id
          AND h2.bbn_active = 1
      WHERE ((bbn_events.`start` BETWEEN ? AND ?)
        OR (bbn_events.`end` BETWEEN ? AND ?))".
        (!empty($model->data['staff']) ? " AND bbn_hr_staff.id = ?" : '').
        (!empty($model->data['status']) ? " AND bbn_hr_staff_events.status = ?" : ''),
      ...$args
    )
  ];
}

if ( !empty($where) ){
  return [
    'data' => $model->db->rselectAll([
      'table' => 'bbn_events',
      'fields' => [
        'bbn_events.id',
        'bbn_events.id_type',
        'bbn_events.start',
        'bbn_events.end',
        'bbn_hr_staff_events.id_staff',
        'bbn_hr_staff_events.status',
        'bbn_hr_staff_events.note',
        'staff' => 'bbn_identities.fullname'
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
            'field' => 'bbn_hr_staff_events.id_staff',
            'exp' => 'bbn_hr_staff.id'
          ]]
        ]
      ], [
        'table' => 'bbn_identities',
        'on' => [
          'conditions' => [[
            'field' => 'bbn_identities.id',
            'exp' => 'bbn_hr_staff.id'
          ]]
        ]
      ]],
      'where' => $where
    ])
  ];
}