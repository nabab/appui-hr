<?php
$grid = new \bbn\Appui\Grid($model->db, $model->data, [
  'table' => 'bbn_identities',
  'fields' => [
    'bbn_identities.id',
    'bbn_hr_staff.id_user',
    'bbn_identities.surname',
    'bbn_identities.name',
    'bbn_identities.fullname',
    'email' => 'emails.value',
    'tel' => 'phones.value',
    'naissance' => 'JSON_UNQUOTE(JSON_EXTRACT(bbn_identities.cfg, "$.naissance"))',
    'contact' => 'JSON_UNQUOTE(JSON_EXTRACT(bbn_identities.cfg, "$.contact"))',
    'secu_id' => 'JSON_UNQUOTE(JSON_EXTRACT(bbn_identities.cfg, "$.secu_id"))',
    'adresse' => 'JSON_UNQUOTE(JSON_EXTRACT(bbn_identities.cfg, "$.adresse"))',
    'cp' => 'JSON_UNQUOTE(JSON_EXTRACT(bbn_identities.cfg, "$.cp"))',
    'ville' => 'JSON_UNQUOTE(JSON_EXTRACT(bbn_identities.cfg, "$.ville"))',
    'bbn_users.id_group'
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
  ], [
    'type' => 'left',
    'table' => 'bbn_identities_uauth',
    'alias' => 'email_uauth',
    'on' => [
      'conditions' => [[
        'field' => 'bbn_identities.id',
        'exp' => 'email_uauth.id_identity'
      ]]
    ]
  ], [
    'type' => 'left',
    'table' => 'bbn_uauth',
    'alias' => 'emails',
    'on' => [
      'conditions' => [[
        'field' => 'email_uauth.id_uauth',
        'exp' => 'emails.id'
      ], [
        'field' => 'emails.typology',
        'value' => 'email'
      ]]
    ]
  ], [
    'type' => 'left',
    'table' => 'bbn_identities_uauth',
    'alias' => 'phone_uauth',
    'on' => [
      'conditions' => [[
        'field' => 'bbn_identities.id',
        'exp' => 'phone_uauth.id_identity'
      ]]
    ]
  ], [
    'type' => 'left',
    'table' => 'bbn_uauth',
    'alias' => 'phones',
    'on' => [
      'conditions' => [[
        'field' => 'phone_uauth.id_uauth',
        'exp' => 'phones.id'
      ], [
        'field' => 'phones.typology',
        'value' => 'phone'
      ]]
    ]
  ]],
  'group_by' => 'bbn_identities.id',
  'map' => [
    'callable' => function(&$row, $idx, $par){
      $row['id_group'] = $par['groups'][$row['id_group']];
    },
    'params' => [
      'groups' => $model->db->selectAllByKeys('bbn_users_groups', ['id', 'group'])
    ]
  ]
]);

if ( $grid->check() ){
  return $grid->getExcel() ? $grid->toExcel() : $grid->getDatatable(true);
}
