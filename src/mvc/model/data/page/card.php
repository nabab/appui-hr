<?php
if ( !empty($model->data['id']) ){

  if ( $dashboard = new \bbn\appui\dashboard('hrcard') ){
    $widgets = $dashboard->get_widgets_code();
  }

  $tabs = [];
  if ( $tabs_perm = $model->inc->perm->get_all('hr/page/card/tabs') ){
    foreach ( $tabs_perm as $tab ){
      $tabs[$tab['code']] = $model->inc->perm->has($tab['id']) ? true : false;
    }
  }

  $tiers = new \amiral\tiers($model->db);
  $week_start = strtotime("Last Monday");
  if ( strtolower(date('l')) === 'monday' ){
      $week_start = strtotime('today');
  }
  $week_end = $week_start + (60 * 60 * 24 * 7) - 1;

  $absences = $model->inc->options->options('absences', 'hr', 'appui');
  $events = $model->get_model(APPUI_HR_ROOT . 'data/events', [
    'employe' => $model->data['id'],
    'start' => date('Y-01-01 00:00:00'),
    'end' => date('Y-12-31 23:59:59')
  ]);
  
  foreach ( array_keys($absences) as $type ){
    $absences[$type] = 0;
    $tmp = array_filter($events['data'], function($e) use($type){
      return $e['id_type'] === $type;
    });
    foreach ( $tmp as $t ){
      $absences[$type] += date_diff(date_create($t['end']), date_create($t['start']))->d + 1;
    }
  }

  return array_merge($tiers->get_info($model->data['id']), [
    'tabs' => $tabs,
    'widgets' => !empty($widgets) ? $widgets : [],
    'widgets_order' => !empty($dashboard) ? $dashboard->get_order($widgets) : [],
    'week' => ($week = $model->get_model(APPUI_HR_ROOT . 'data/events', [
      'employe' => $model->data['id'],
      'start' => date('Y-m-d 00:00:00', $week_start),
      'end' => date('Y-m-d 23:59:59', $week_end),
      'week' => true
    ])) ? $week['data'] : [],
    'upcoming' => ($upcoming = $model->get_model(APPUI_HR_ROOT . 'data/events', [
      'employe' => $model->data['id'],
      'start' => date('Y-m-d H:i:s'),
      'end' => date('Y-12-31 23:59:59')
    ])) ? $upcoming['data'] : [],
    'today' => ($today = $model->get_model(APPUI_HR_ROOT . 'data/events', [
      'employe' => $model->data['id'],
      'day' => date('Y-m-d')
    ])) ? $today['data'] : [],
    'entities' => $model->db->rselect_all([
      'table' => 'amiral_entities',
      'fields' => [
        'amiral_entities.id',
        'amiral_entities.nom',
        'amiral_entities.type_entity',
        'bbn_addresses.fulladdress',
        'amiral_liens.cfg'
      ],
      'join' => [[
        'table' => 'amiral_liens',
        'on' => [
          'conditions' => [[
            'field' => 'amiral_liens.id_entity',
            'exp' => 'amiral_entities.id'
          ], [
            'field' => 'amiral_liens.type_lien',
            'value' => $model->inc->options->from_code('responsable', 'liens')
          ], [
            'field' => 'amiral_liens.id_tiers',
            'value' => $model->data['id']
          ]]
        ]
      ], [
        'table' => 'amiral_liens',
        'alias' => 'lie',
        'on' => [
          'conditions' => [[
            'field' => 'lie.id_entity',
            'exp' => 'amiral_liens.id_entity'
          ], [
            'field' => 'lie.type_lien',
            'value' => $model->inc->options->from_code('siege', 'liens')
          ]]
        ]
      ], [
        'table' => 'bbn_addresses',
        'on' => [
          'conditions' => [[
            'field' => 'bbn_addresses.id',
            'exp' => 'lie.id_lieu'
          ]]
        ]
      ]]
    ]),
    'summary' => $absences
  ]);
}