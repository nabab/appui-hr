<?php

try {
  $dashboard = new \bbn\Appui\Dashboard('hr');
  $widgets = $dashboard->getUserWidgetsCode(APPUI_HR_ROOT . 'data/home/widget/');
}
catch ( Exception $e ){
  $dashboard = false;
  $widgets = [];
}

$ret = [
  'tabs' => [
    'home' => [
      'url' => 'home',
      'component' => 'appui-hr-tab-home',
      'icon' => 'nf nf-fa-home',
      'title' => _('Dashboard'),
      'bcolor' => 'teal',
      'fcolor' => 'white',
      'source' => [
        'widgets' => !empty($widgets) ? $widgets : [],
        'widgets_order' => !empty($dashboard) ? $dashboard->getOrder($widgets) : []
      ]
    ],
    'staff' => [
      'url' => 'staff',
      'component' => 'appui-hr-tab-staff',
      'icon' => 'nf nf-oct-organization',
      'title' => _('Staff list'),
      'bcolor' => 'sandybrown',
      'fcolor' => 'white',
    ],
    'planning' => [
      'url' => 'planning',
      'component' => 'appui-hr-tab-planning',
      'icon' => 'nf nf-md-calendar_clock',
      'title' => _('Planning'),
      'bcolor' => 'yellowgreen',
      'fcolor' => 'white',
      'components' => [
        'day' => 'appui-hr-tab-planning-day',
        'events' => 'appui-hr-tab-planning-events'
      ]
    ],
    'holidays' => [
      'url' => 'holidays',
      'component' => 'appui-hr-tab-holidays',
      'icon' => 'nf nf-md-beach',
      'title' => _('Holidays'),
      'bcolor' => 'skyblue',
      'fcolor' => 'white'
    ]
  ]
];

if ( $cfg = $model->getPluginModel('page') ){
  $ret['tabs'] = empty($cfg['tabs']) ? $ret['tabs'] : \bbn\X::mergeArrays($ret['tabs'], $cfg['tabs']);
}

if (
  ($tabs_perm = $model->inc->perm->getAll(APPUI_HR_ROOT . '/page')) &&
  (($t = \bbn\X::find($tabs_perm, ['code' => 'tabs'])) !== null) &&
  ($tabs_perm = $model->inc->perm->getAll($tabs_perm[$t]['id']))
){
  foreach ( $ret['tabs'] as $code => $tab ){
    $idx = \bbn\X::find($tabs_perm, ['code' => $code]);
    if (
      ($idx === null) ||
      !$model->inc->perm->has($tabs_perm[$idx]['id'])
    ){
      unset($ret['tabs'][$code]);
    }
    else {
      if ( !empty($tabs_perm[$idx]['num_children']) ){
        $subtabs = $model->inc->perm->getAll($tabs_perm[$idx]['id']);
        foreach ( $subtabs as $subtab ){
          if ( $model->inc->perm->has($subtab['id']) ){
            if ( !array_key_exists('tabs', $ret['tabs'][$code]) ){
              $ret['tabs'][$code]['tabs'] = [];
            }
            $ret['tabs'][$code]['tabs'][$subtab['code']] = true;
          }
        }
      }
    }
  }
}
else {
  $ret['tabs'] = [];
}

$ret['perms'] = [
  'write' => $model->inc->perm->has('hr/perms/write'),
  'cards' => $model->inc->perm->has('hr/perms/cards')
];
if ( !empty($cfg) && !empty($cfg['perms']) ){
  $ret['perms'] = \bbn\X::mergeArrays($ret['perms'], $cfg['perms']);
}

return $ret;