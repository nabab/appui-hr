<?php
$cfg = $model->inc->user->get_class_cfg();
$manager = $model->inc->user->get_manager();
$tiers = new \amiral\tiers($model->db);
$ok = false;
if ( !empty($model->data[$cfg['arch']['users']['id_group']]) ){
  $username = "";
  if ( !empty($model->data['name']) ){
    $username .= $model->data['name'].' ';
  }
  if ( !empty($model->data['surname']) ){
    $username .= $model->data['surname'];
  }

  if ( 
    isset($model->data[$cfg['arch']['users']['id_group']], $model->data[$cfg['arch']['users']['email']]) &&
    \bbn\str::is_email($model->data[$cfg['arch']['users']['email']])
   ){
    $data_user = [
      $cfg['arch']['users']['id_group'] => $model->data['id_group'],
      $cfg['arch']['users']['username'] => $username,
      $cfg['arch']['users']['email'] => $model->data['email'],
      $cfg['arch']['users']['login'] => $model->data['email'],
      $cfg['arch']['users']['admin'] => 0,
      $cfg['arch']['users']['dev'] => 0,
      $cfg['arch']['users']['cfg'] => '{}',
      $cfg['arch']['users']['active'] => 1,
      $cfg['arch']['users']['tel'] => $model->data['tel'],
      $cfg['arch']['users']['fonction'] => '',
      $cfg['arch']['users']['theme'] => 'default'
    ];

    if ( 
      !empty($model->data['id_user']) ||
      ($model->data['id_user'] = $model->db->select_one(
        $cfg['table'],
        $cfg['arch']['users']['id'],
        [$cfg['arch']['users']['email'] => $model->data[$cfg['arch']['users']['email']]]
      ))
    ){
      $manager->reactivate($model->data['id_user']);
      $manager->edit($data_user, $model->data['id_user']);
      $manager->set_unique_group($model->data['id_user'], $model->data['id_group']);
      $ok = true;
    }
    else {
      if ($user = $manager->add($data_user) ){
        $ok = true;
        $model->data['id_user'] = $user[$cfg['arch']['users']['id']];
        $manager->set_unique_group($user[$cfg['arch']['users']['id']], $model->data['id_group']);
      }
    }
  }
}
else if ( 
  !empty($model->data['id_user']) || 
  (
    !empty($model->data[$cfg['arch']['users']['email']]) &&
    ($model->data['id_user'] = $model->db->select_one(
      $cfg['table'],
      $cfg['arch']['users']['id'],
      [$cfg['arch']['users']['email'] => $model->data[$cfg['arch']['users']['email']]]
    ))
  )
){
  $manager->deactivate($model->data['id_user']);
  $ok = true;
}

$ok2 = $tiers->update($model->data['id'], [
  'surname' => $model->data['surname'],
  'name' => $model->data['name'],
  'tel' => $model->data['tel'],
  'email' => $model->data['email'],
  'adresse' => $model->data['adresse'],
  'cp' => $model->data['cp'],
  'ville' => $model->data['ville'],
  'naissance' => $model->data['naissance'],
  'secu_id' => $model->data['secu_id'],
  'contact' => $model->data['contact']
]);

$ok3 = $model->db->update('bbn_hr_staff', [
  'id_user' => empty($model->data[$cfg['arch']['users']['id_group']]) ? 
    NULL : 
    $model->data['id_user']
], [
  'id' => $model->data['id']
]);

if ( $ok || $ok2 || $ok3 ){
  return [
    'success' => true,
    'data' => [
      'id_user' => empty($model->data[$cfg['arch']['users']['id_group']]) ? 
        null : 
        $model->data['id_user']
    ]
  ];
}
return ['success' => false];
