<?php
$grid = new \bbn\appui\grid($model->db, $model->data, [
  'table' => 'bbn_people',
  'fields' => [
    'bbn_people.id',
    'bbn_hr_staff.id_user',
    'bbn_people.surname',
    'bbn_people.name',
    'bbn_people.fullname',
    'bbn_people.email',
    'bbn_people.tel',
    'naissance' => 'bbn_people.cfg->>"$.naissance"',
    'contact' => 'bbn_people.cfg->>"$.contact"',
    'secu_id' => 'bbn_people.cfg->>"$.secu_id"',
    'adresse' => 'bbn_people.cfg->>"$.adresse"',
    'cp' => 'bbn_people.cfg->>"$.cp"',
    'ville' => 'bbn_people.cfg->>"$.ville"',
    'bbn_users.id_group'
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
    'table' => 'bbn_users',
    'type' => 'left',
    'on' => [
      'conditions' => [[
        'field' => 'bbn_hr_staff.id_user',
        'exp' => 'bbn_users.id'
      ], [
        'field' => 'bbn_users.bbn_h',
        'value' => 1
      ]]
    ]
  ]],
  'map' => [
    'callable' => function(&$row, $idx, $par){
      $row['id_group'] = $par['groups'][$row['id_group']];
    },
    'params' => [
      'groups' => $model->db->select_all_by_keys('bbn_users_groups', ['id', 'group'])
    ]
  ]
]);

if ( $grid->check() ){
  return $grid->get_excel() ? $grid->to_excel() : $grid->get_datatable(true);
}
