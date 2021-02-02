<?php
if ( $m = $ctrl->getPluginModel('employes') ){
  $ctrl->obj = $m;
}
else {
  $ctrl->action();
}
