<?php
if ( !empty($ctrl->arguments) ){
  $ctrl->data = $ctrl->get_model(APPUI_HR_ROOT . 'data/page/card', ['id' => $ctrl->arguments[0]]);
  $ctrl
    ->set_url(APPUI_HR_ROOT . 'page/card/' . $ctrl->data['id'])
    ->set_icon('nf nf-mdi-worker bbn-large')
    ->combo($ctrl->data['fullname'], true);
}