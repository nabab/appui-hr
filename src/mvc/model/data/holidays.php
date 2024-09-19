<?php
if ( 
  !empty($model->data['filters']) &&
  !empty($model->data['filters']['conditions']) &&
  (($idx = \bbn\X::find($model->data['filters']['conditions'], ['field' => 'id_staff'])) !== null)
){
  $model->data['filters']['conditions'][$idx]['field'] = 'bbn_identities.id';
}
$grid = new \bbn\Appui\Grid($model->db, $model->data, [
  'table' => 'bbn_identities',
  'fields' => [
    'id_staff' => 'bbn_identities.id',
    'bbn_hr_staff_events.id_event',
    'bbn_events.start',
    'bbn_events.end',
    'bbn_events.id_type',
    'bbn_hr_staff_events.note',
    'bbn_hr_staff_events.status',
		'substitutes' => "GROUP_CONCAT(DISTINCT LOWER(HEX(plan.id_staff)) SEPARATOR ',')"
  ],
  'join' => [[
    'table' => 'bbn_hr_staff',
    'on' => [
      'conditions' => [[
        'field' => 'bbn_identities.id',
        'exp' => 'bbn_hr_staff.id'
      ]]
    ]
  ], [
    'table' => 'bbn_hr_staff_events',
    'on' => [
      'conditions' => [[
        'field' => 'bbn_hr_staff.id',
        'exp' => 'bbn_hr_staff_events.id_staff'
      ]]
    ]
  ], [
    'table' => 'bbn_events',
    'on' => [
      'conditions' => [[
        'field' => 'bbn_events.id',
        'exp' => 'bbn_hr_staff_events.id_event'
      ]/*, [
        'field' => 'bbn_events.end',
        'operator' => '>=',
        'value' => date('Y-01-01 00:00:00')
      ]*/]
    ]
  ], [
		'table' => 'bbn_hr_planning',
		'type' => 'left',
		'on' => [
			'conditions' => [[
				'field' => 'bbn_hr_planning.id_staff',
				'exp' => 'bbn_identities.id'
			]]
		]
	], [
		'table' => 'bbn_hr_planning',
		'type' => 'left',
		'alias' => 'plan',
		'on' => [
			'conditions' => [[
				'field' => 'bbn_hr_planning.id',
				'exp' => 'plan.id_alias'
      ], [
        'field' => 'plan.alias',
        'operator' => '>=',
        'exp' => 'bbn_events.start'
      ], [
        'field' => 'plan.alias',
        'operator' => '<=',
        'exp' => 'bbn_events.end'
      ]]
		]
	]],
  /* 'filters' => [
    'logic' => 'OR',
    'conditions'=> [[
      'conditions' => [[
        'field' => 'bbn_events.start',
        'operator' => '<=',
        'value' => date('Y-01-01 00:00:00')
      ], [
        'field' => 'bbn_events.end',
        'operator' => '>=',
        'value' => date('Y-12-31 23:59:59')
      ]]
    ], [
			'field' => 'bbn_events.start',
			'operator' => '>',
			'value' => date('Y-01-01 00:00:00')
		]]
  ], */
  'group_by' => ['bbn_events.id'],
  'map' => [
    'callable' => function(&$row, $idx, $par){
      $row['id_staff'] = $par['staff'][$row['id_staff']];
      $row['id_type'] = $par['types'][$row['id_type']];
      $sub = '';
      if ( !empty($row['substitutes']) ){
        $ar = explode(',', $row['substitutes']);
        foreach ( $ar as $i => $s ){
          $sub .= $par['staff'][$s];
          if ( !empty($ar[$i+1]) ){
            $sub .= PHP_EOL;
          }
        }
      }
      $row['substitutes'] = $sub;
    },
    'params' => [
      'staff' => $model->db->selectAllByKeys([
        'table' => 'bbn_identities',
        'fields' => ['id', 'fullname'],
        'join' => [[
          'table' => 'bbn_history_uids',
          'on' => [
            'conditions' => [[
              'field' => 'bbn_identities.id',
              'exp' => 'bbn_history_uids.bbn_uid'
            ]]
          ]
        ]]
      ]),
      'types' => $model->inc->options->options('absences', 'hr', 'appui')
    ]
  ]
]);

if ( $grid->check() ){
  return $grid->getExcel() ? $grid->toExcel() : $grid->getDatatable(true);
}
