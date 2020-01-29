<?php
/* @var \bbn\mvc\model $model */
if ( 
  !empty($model->data['day']) &&
  !empty($model->data['id_staff']) &&
  !empty($model->data['id_entity']) &&
  !empty($model->data['hour']) &&
  ($pla = new \bbn\appui\planning($model->db))
){
  $ecfg = $pla->get_events()->get_class_cfg();
  $ef = $ecfg['arch']['events'];
  $rf = $ecfg['arch']['recurring'];
  $h = floor($model->data['hour']);
  $m = ($model->data['hour'] - $h) === 0.5 ? 30 : 0;
  $start = $model->data['day'].' 08:00:00';
  $end = new DateTime($start);
  $end->add(new DateInterval('PT'.$h.'H'.$m.'M'));
  $end = $end->format('Y-m-d H:i:s');

  if ( $pla->insert(
    $model->data['id_staff'],
    [
      $ef['start'] => $start,
      $ef['end'] => $end,
      $ef['id_type'] => $model->inc->options->from_code('wp', 'events', 'appui'),
      $ef['recurring'] => empty($model->data[$ef['recurring']]) ? 0 : 1,
      $rf['type'] => $model->data[$rf['type']],
      $rf['interval'] => $model->data[$rf['interval']],
      $rf['occurrences'] => $model->data[$rf['occurrences']],
      $rf['until'] => $model->data[$rf['until']],
      $rf['wd'] => $model->data[$rf['wd']],
      $rf['mw'] => $model->data[$rf['mw']],
      $rf['md'] => $model->data[$rf['md']],
      $rf['ym'] => $model->data[$rf['ym']]
    ]
  ) ){
    return ['success' => true];
  }
}
return ['success' => false]; 