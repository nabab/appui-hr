<?php
if ( !empty($ctrl->arguments) ){
  $ctrl->data = $ctrl->get_model(APPUI_HR_ROOT . 'data/page/card', ['id' => $ctrl->arguments[0]]);
  if ( $m = $ctrl->get_plugin_model('data/page/card', ['id' => $ctrl->arguments[0]]) ){
    $ctrl->data = array_merge($ctrl->data, $m);
  }
  $ctrl->data['id'] = $ctrl->data['info']['id'];
  unset($ctrl->data['info']['id']);
  $ctrl
    ->set_url(APPUI_HR_ROOT . 'page/card/' . $ctrl->data['id'])
    ->set_icon('nf nf-mdi-worker bbn-large')
    ->combo($ctrl->data['info']['fullname'], true);
}