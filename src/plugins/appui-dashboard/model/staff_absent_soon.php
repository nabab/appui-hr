<?php
$grid = new \bbn\Appui\Grid($model->db, $model->data, [
  'table' => 'bbn_people',
  'fields' => [
    'bbn_people.id',
    'bbn_events.start',
    'bbn_events.end',
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
        'exp' => 'bbn_hr_staff_events.id_staff'
      ], [
        'field' => 'bbn_hr_staff_events.status',
        'value' => 'accepted'
      ]]
    ]
  ], [
    'table' => 'bbn_events',
    'on' => [
      'conditions' => [[
        'field' => 'bbn_events.id',
        'exp' => 'bbn_hr_staff_events.id_event'
      ]]
    ]
  ]],
  'filters' => [
    'conditions' => [[
      'field' => 'bbn_events.start',
      'operator' => '>',
      'value' => date('Y-m-d 00:00:00')
    ]]
  ]
]);
if ( $grid->check() ){
  return $grid->getDatatable(true);
}