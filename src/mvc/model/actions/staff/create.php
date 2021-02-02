<?php
$cfg = $model->inc->user->getClassCfg();

if (
  empty($model->data[$cfg['arch']['users']['id']]) &&
 !empty($model->data['surname']) &&
 ($tiers = new \amiral\tiers($model->db))
){
  $username = "";
  if ( !empty($model->data['name']) ){
    $username .= $model->data['name'].' ';
  }
  if ( !empty($model->data['surname']) ){
    $username .= $model->data['surname'];
  }

  if (
    isset($model->data[$cfg['arch']['users']['id_group']], $model->data[$cfg['arch']['users']['email']]) &&
    \bbn\Str::isEmail($model->data[$cfg['arch']['users']['email']])
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
      ($manager = $model->inc->user->getManager()) &&
      ($user = $manager->add($data_user)) &&
      !empty($user[$cfg['arch']['users']['id']])
    ){
      $manager->setUniqueGroup($user[$cfg['arch']['users']['id']], $model->data['id_group']);
    }
  }

  if (
    ($id_staff = $tiers->add([
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
    ], true)) &&
    $model->db->insert('bbn_hr_staff', [
      'id' => $id_staff,
      'id_user' => !empty($model->data['id_group']) && !empty($user[$cfg['arch']['users']['id']]) ?
        $user[$cfg['arch']['users']['id']] :
        NULL
    ])
  ){
    return [
      'success' => true,
      'data' => [
        'id_staff' => $id_staff,
        'id_user' => !empty($model->data['id_group']) && !empty($user[$cfg['arch']['users']['id']]) ?
          $user[$cfg['arch']['users']['id']] :
          null
      ]
    ];
  }
}
return ['success' => false];
