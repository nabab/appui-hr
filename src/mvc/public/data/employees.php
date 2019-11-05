<?php
if ( $m = $ctrl->get_plugin_model('employes') ){
  $ctrl->obj = $m;
}
else {
  $ctrl->action();
}
