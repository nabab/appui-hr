<?php
$can_see_cards = $ctrl->inc->perm->has('hr/perms/cards');
$id_user = $ctrl->inc->user->get_id();
$current_id_staff = $ctrl->db->select_one('bbn_hr_staff', 'id', ['id_user' => $id_user]);
$id_staff = !empty($ctrl->arguments) && \bbn\str::is_uid($ctrl->arguments[0]) ?
  $ctrl->arguments[0] :
  $current_id_staff;
if ( !empty($id_staff) ){
  if (
    !$ctrl->inc->user->is_admin() &&
    !$ctrl->inc->user->is_dev() &&
    (
      empty($current_id_staff) ||
      (
        ($current_id_staff !== $id_staff) &&
        !$can_see_cards
      )
    )
  ){
    $ctrl->obj->errorTitle = _("Unauthorized");
    $ctrl->obj->error = _("Sorry but you don't have the permission for ".$ctrl->get_path());
  }
  else {
    $ctrl->data = $ctrl->get_model(APPUI_HR_ROOT . 'data/page/card', ['id' => $id_staff]);
    if ( $m = $ctrl->get_plugin_model('data/page/card', ['id' => $id_staff]) ){
      $ctrl->data = array_merge($ctrl->data, $m);
    }
    $ctrl->data['id'] = $ctrl->data['info']['id'];
    //unset($ctrl->data['info']['id']);
    $ctrl
      ->set_url(APPUI_HR_ROOT . 'page/card/' . $ctrl->data['id'])
      ->set_icon('nf nf-mdi-worker bbn-large')
      ->combo($ctrl->data['info']['fullname'], true);
  }
}