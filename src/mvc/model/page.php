<?php

if ( $dashboard = new \bbn\appui\dashboard('hr') ){
  $widgets = $dashboard->get_widgets_code(APPUI_HR_ROOT . 'data/home/widget/');
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
        'widgets_order' => !empty($dashboard) ? $dashboard->get_order($widgets) : []
      ]
    ],
    'employes' => [
      'url' => 'employees',
      'component' => 'appui-hr-tab-employees',
      'icon' => 'nf nf-oct-organization',
      'title' => _('Employees list'),
      'bcolor' => 'sandybrown',
      'fcolor' => 'white',
    ],
    'planning' => [
      'url' => 'planning',
      'component' => 'appui-hr-tab-planning',
      'icon' => 'nf nf-mdi-calendar_clock',
      'title' => _('Planning'),
      'bcolor' => 'yellowgreen',
      'fcolor' => 'white'
    ],
    'holidays' => [
      'url' => 'holidays',
      'component' => 'appui-hr-tab-holidays',
      'icon' => 'nf nf-mdi-beach',
      'title' => _('Holydas'),
      'bcolor' => 'skyblue',
      'fcolor' => 'white'
    ]
  ]
];

if ( $cfg = $model->get_plugin_model('page') ){
  $ret['tabs'] = empty($cfg['tabs']) ? $ret['tabs'] : \bbn\x::merge_arrays($ret['tabs'], $cfg['tabs']);
}

return $ret;