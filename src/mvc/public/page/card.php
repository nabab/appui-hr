<?php
$id = !empty($ctrl->arguments) && \bbn\str::is_uid($ctrl->arguments[0]) ? $ctrl->arguments[0] : $ctrl->db->select_one('bbn_hr_staff', 'id', ['id_user' => $ctrl->inc->user->get_id()]);
if ( !empty($id) ){
  $ctrl->data = $ctrl->get_model(APPUI_HR_ROOT . 'data/page/card', ['id' => $id]);
  if ( $m = $ctrl->get_plugin_model('data/page/card', ['id' => $id]) ){
    $ctrl->data = array_merge($ctrl->data, $m);
  }
  $ctrl->data['id'] = $ctrl->data['info']['id'];
  unset($ctrl->data['info']['id']);
  $ctrl
    ->set_url(APPUI_HR_ROOT . 'page/card/' . $ctrl->data['id'])
    ->set_icon('nf nf-mdi-worker bbn-large')
    ->combo($ctrl->data['info']['fullname'], true);
}