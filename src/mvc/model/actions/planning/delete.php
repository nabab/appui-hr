<?php
/* @var \bbn\Mvc\Model $model */
if ( !empty($model->data['day']) && !empty($model->data['id']) ){
  if ( empty($model->data['toJSON']) ){
    if ( 
      ($id_event = $model->db->selectOne('amiral_planning', 'id_event', ['id' => $model->data['id']])) &&
      $model->db->delete('amiral_planning', ['id' => $model->data['id']]) &&
      $model->db->delete('bbn_events', ['id' => $id_event])
    ){
      return [
        'success' => true,
        'json' => false
      ];
    }
  }
  else {
    $year = date('Y', strtotime($model->data['day']));
    $filename = date('Y-m', strtotime($model->data['day'])).'.json';
    $path = BBN_DATA_PATH."/hr/planning/$year/";
    if ( 
      is_file($path.$filename) && 
      ($d = file_get_contents($path.$filename)) &&
      ($d = json_decode($d, true)) &&
      (($idx = \bbn\X::find($d, ['id' => $model->data['id']])) !== null)
    ){
      unset($d[$idx]);
      if ( file_put_contents($path.$filename, Json_encode(array_values($d))) && is_file($path.$filename) ){
        return [
          'json' => filemtime($path.$filename),
          'success' => true
        ];
      }
    }
  }
}
return ['success' => false]; 