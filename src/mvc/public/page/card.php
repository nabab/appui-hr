<?php
$can_see_cards = $ctrl->inc->perm->has('hr/perms/cards');
$id_user = $ctrl->inc->user->getId();
$current_id_staff = $ctrl->db->selectOne('bbn_hr_staff', 'id', ['id_user' => $id_user]);
$id_staff = !empty($ctrl->arguments) && \bbn\Str::isUid($ctrl->arguments[0]) ?
  $ctrl->arguments[0] :
  $current_id_staff;
if ( !empty($id_staff) ){
  if (
    !$ctrl->inc->user->isAdmin() &&
    !$ctrl->inc->user->isDev() &&
    (
      empty($current_id_staff) ||
      (
        ($current_id_staff !== $id_staff) &&
        !$can_see_cards
      )
    )
  ){
    $ctrl->obj->errorTitle = _("Unauthorized");
    $ctrl->obj->error = _("Sorry but you don't have the permission for ".$ctrl->getPath());
  }
  else {
    $ctrl->data = $ctrl->getModel(APPUI_HR_ROOT . 'data/page/card', ['id' => $id_staff]);
    if ( $m = $ctrl->getPluginModel('data/page/card', ['id' => $id_staff]) ){
      $ctrl->data = array_merge($ctrl->data, $m);
    }
    $ctrl->data['id'] = $ctrl->data['info']['id'];
    //unset($ctrl->data['info']['id']);
    $ctrl
      ->setUrl(APPUI_HR_ROOT . 'page/card/' . $ctrl->data['id'])
      ->setIcon('nf nf-mdi-worker bbn-large')
      ->combo($ctrl->data['info']['fullname'], true);
  }
}