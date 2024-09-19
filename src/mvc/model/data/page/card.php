<?php
if ( !empty($model->data['id']) ){

  if ( $dashboard = new \bbn\Appui\Dashboard('hrcard') ){
    $widgets = $dashboard->getUserWidgetsCode();
  }

  $tabs = [];
  if ( $tabs_perm = $model->inc->perm->getAll(APPUI_HR_ROOT . '/page/card/tabs') ){
    foreach ( $tabs_perm as $tab ){
      $tabs[$tab['code']] = !!$model->inc->perm->has($tab['id']);
    }
  }

  $week_start = strtotime("Last Monday");
  if ( strtolower(date('l')) === 'monday' ){
      $week_start = strtotime('today');
  }
  $week_end = $week_start + (60 * 60 * 24 * 7) - 1;

  $absences = $model->inc->options->options('absences', 'hr', 'appui');
  $events = $model->getModel(APPUI_HR_ROOT . 'data/events', [
    'staff' => $model->data['id'],
    'start' => date('Y-01-01 00:00:00'),
    'end' => date('Y-12-31 23:59:59')
  ]);  
  foreach ( array_keys($absences) as $type ){
    $absences[$type] = 0;
    $tmp = array_filter($events['data'], function($e) use($type){
      return $e['id_type'] === $type;
    });
    foreach ( $tmp as $t ){
      $absences[$type] += date_diff(date_create($t['end']), Date_create($t['start']))->d + 1;
    }
  }

  $info = $model->db->rselect('bbn_identities', [], ['id' => $model->data['id']]);
  if ( \bbn\Str::isJson($info['cfg']) ){
    $info = array_merge($info, Json_decode($info['cfg'], true));
  }

  return [
    'info' => $info,
    'tabs' => $tabs,
    'widgets' => !empty($widgets) ? $widgets : [],
    'widgets_order' => !empty($dashboard) ? $dashboard->getOrder($widgets) : [],
    'week' => ($week = $model->getModel(APPUI_HR_ROOT . 'data/events', [
      'staff' => $model->data['id'],
      'start' => date('Y-m-d 00:00:00', $week_start),
      'end' => date('Y-m-d 23:59:59', $week_end),
      'week' => true,
      'status' => 'accepted'
    ])) ? $week['data'] : [],
    'upcoming' => ($upcoming = $model->getModel(APPUI_HR_ROOT . 'data/events', [
      'staff' => $model->data['id'],
      'start' => date('Y-m-d H:i:s'),
      'end' => date('Y-12-31 23:59:59'),
      'status' => 'accepted'
    ])) ? $upcoming['data'] : [],
    'today' => ($today = $model->getModel(APPUI_HR_ROOT . 'data/events', [
      'staff' => $model->data['id'],
      'day' => date('Y-m-d'),
      'status' => 'accepted'
    ])) ? $today['data'] : [],
    'summary' => $absences
  ];
}