<?php
$grid = new \bbn\appui\grid($model->db, $model->data, [
  'table' => 'bbn_people',
  'fields' => [
    'id_employe' => 'bbn_people.id',
    'bbn_events.start',
    'bbn_events.end',
    'bbn_events.id_type',
    'bbn_hr_staff_events.note',
		'employes' => "GROUP_CONCAT(DISTINCT LOWER(HEX(plan.id_employe)) SEPARATOR ',')"
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
		'table' => 'bbn_events',
		'type' => 'left',
		'alias' => 'events',
		'on' => [
			'conditions' => [[
				'field' => 'events.start',
				'operator' => '>=',
				'exp' => 'bbn_events.start'
			], [
				'field' => 'events.start',
				'operator' => '<=',
				'exp' => 'bbn_events.end'
			], [
				'field' => 'events.id_type',
				'value' => $model->inc->options->from_code('wp', 'events', 'appui')
			]]
		]
	], [
		'table' => 'amiral_planning',
		'type' => 'left',
		'on' => [
			'conditions' => [[
				'field' => 'amiral_planning.id_event',
				'exp' => 'events.id'
			], [
				'field' => 'amiral_planning.id_employe',
				'exp' => 'bbn_people.id'
			]]
		]
	], [
		'table' => 'amiral_planning',
		'type' => 'left',
		'alias' => 'plan',
		'on' => [
			'conditions' => [[
				'field' => 'amiral_planning.id',
				'exp' => 'plan.id_alias'
			]]
		]
	]],
  'filters' => [
    'logic' => 'OR',
    'conditions'=> [[
      'conditions' => [[
        'field' => 'bbn_events.start',
        'operator' => '<=',
        'value' => date('Y-m-d 00:00:00')
      ], [
        'field' => 'bbn_events.end',
        'operator' => '>=',
        'value' => date('Y-m-d 23:59:59')
      ]]
    ], [
			'field' => 'bbn_events.start',
			'operator' => '>',
			'value' => date('Y-m-d 00:00:00')
		]]
  ],
	'group_by' => ['bbn_events.id']
]);

if ( $grid->check() ){
  return $grid->get_datatable(true);
}
