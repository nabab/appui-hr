<?php
/* @var \bbn\mvc\model $model */
if ( !empty($model->data['data']['start']) && !empty($model->data['data']['end']) ){
  if ( $events = $model->db->get_rows("
      SELECT bbn_events.id, bbn_events.`start` AS start, bbn_events.`end` AS end,
        bbn_hr_staff.id AS id_employe
      FROM bbn_events
        JOIN amiral_planning
          ON amiral_planning.id_event = bbn_events.id
        JOIN bbn_hr_staff
          ON bbn_hr_staff.id = amiral_planning.id_employe
        JOIN bbn_people
          ON bbn_people.id = bbn_hr_staff.id
        JOIN amiral_entities
          ON amiral_entities.id = amiral_planning.id_entity
        JOIN bbn_history_uids AS h1
          ON h1.bbn_uid = bbn_events.id
          AND h1.bbn_active = 1
        JOIN bbn_history_uids AS h2
          ON h2.bbn_uid = bbn_people.id
          AND h2.bbn_active = 1
        JOIN bbn_history_uids AS h3
          ON h3.bbn_uid = amiral_entities.uid
          AND h3.bbn_active = 1
      WHERE bbn_events.id_type = ?
        AND (
          (bbn_events.`start` BETWEEN ? AND ?) 
          OR (bbn_events.`end` BETWEEN ? AND ?)
        )",
      hex2bin($model->inc->options->from_code('wp', 'events', 'appui')),
      $model->data['data']['start'],
      $model->data['data']['end'],
      $model->data['data']['start'],
      $model->data['data']['end']
    ) ){
    return [
      'data' => $events,
      'json' => false,
      'success' => true
    ];
  }
  else if ( date('Y-m', strtotime($model->data['data']['start'])) < date('Y-m') ){
    return [
      'data' => [],
      'json' => false,
      'success' => true
    ];
  }
  else {
    $year = date('Y', strtotime($model->data['data']['start']));
    $filename = date('Y-m', strtotime($model->data['data']['start'])).'.json';
    $path = $model->data_path('appui-hr')."planning/$year/";
    if ( \bbn\file\dir::create_path($path) ){
      if ( !is_file($path.$filename) || !empty($model->data['data']['force']) ){
        if ( $liens = $model->db->rselect_all([
          'table' => 'amiral_liens',
          'fields' => [
            'amiral_liens.id',
            'amiral_liens.id_entity',
            'amiral_liens.id_tiers',
            'amiral_liens.cfg'
          ],
          'join' => [[
            'table' => 'amiral_entities',
            'on' => [
              'conditions' => [[
                'field' => 'amiral_entities.id',
                'exp' => 'amiral_liens.id_entity'
              ]]
            ]
          ], [
            'table' => 'bbn_people',
            'on' => [
              'conditions' => [[
                'field' => 'bbn_people.id',
                'exp' => 'amiral_liens.id_tiers'
              ]]
            ]
          ], [
            'table' => 'bbn_hr_staff',
            'on' => [
              'conditions' => [[
                'field' => 'bbn_people.id',
                'exp' => 'bbn_hr_staff.id'
              ]]
            ]
          ]],
          'where' => [
            'conditions' => [[
              'field' => 'amiral_liens.type_lien',
              'value' => $model->inc->options->from_code('responsable', 'liens')
            ]]
          ]
        ]) ){
          function get_days($d, $m){
            $t = strtotime($m);
            $last = strtotime("last $d of this month", $t);
            $ret = [
              date('Y-m-d', strtotime("first $d of this month", $t)),
              date('Y-m-d', strtotime("second $d of this month", $t)),
              date('Y-m-d', strtotime("third $d of this month", $t)),
            ];
            if ( ($fourth = strtotime("fourth $d of this month", $t)) && ($fourth <= $last) ){
              $ret[] = date('Y-m-d', $fourth);
            }
            if ( ($fifth = strtotime("fifth $d of this month", $t)) && ($fifth <= $last) ){
              $ret[] = date('Y-m-d', $fifth);
            }
            return $ret;
          }
          $ym = date('Y-m', strtotime($model->data['data']['start']));
          $days = [
            'monday' => get_days('monday', $ym),
            'tuesday' => get_days('tuesday', $ym),
            'wednesday' => get_days('wednesday', $ym),
            'thursday' => get_days('thursday', $ym),
            'friday' => get_days('friday', $ym),
            'saturday' => get_days('saturday', $ym),
          ];
          $entities = [];
          $tojson = [];
          foreach ( $liens as $lien ){
            if ( !isset($entities[$lien['id_entity']]) ){
              $ent = new \amiral\entities\entity($lien['id_entity'], $model->db);
              $entities[$lien['id_entity']] = [
                'nom' => $ent->get_nom(),
                'adresse' => $ent->get_siege()
              ];
            }
            if ( $cfg = json_decode($lien['cfg'], true) ){
              foreach ( $cfg as $i => $v ){
                if ( !empty($v) ){
                  $h = floor($v);
                  $m = ($v - $h) === 0.5 ? 30 : 0;
                  foreach ( $days[$i] as $d ){
                    $end = new DateTime($d.' 08:00:00');
                    $end->add(new DateInterval('PT'.$h.'H'.$m.'M'));
                    $tojson[] = [
                      'id' => \bbn\x::make_uid(),
                      'start' => $d.' 08:00:00',
                      'end' => $end->format('Y-m-d H:i:s'),
                      'id_employe' => $lien['id_tiers'],
                      'id_entity' => $lien['id_entity'],
                      'entity_nom' => $entities[$lien['id_entity']]['nom'],
                      'entity_adresse' => $entities[$lien['id_entity']]['adresse']
                    ];
                  }
                }
              }
            }
          }
          file_put_contents($path.$filename, json_encode($tojson));
        }
      }
      if ( is_file($path.$filename) && ($d = file_get_contents($path.$filename)) ){
        return [
          'data' => json_decode($d, true),
          'json' => filemtime($path.$filename),
          'success' => true
        ];
      } 
    }
  }
}
return ['success' => false];