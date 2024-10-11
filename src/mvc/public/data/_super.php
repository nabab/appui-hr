<?php
$path = $ctrl->getPath();
$path = explode('/', $path);
array_shift($path);
$path = implode('/', $path);
if ( $m = $ctrl->getPluginModel($path, $ctrl->post) ){
  $ctrl->obj = $m;
  return false;
}
return true;