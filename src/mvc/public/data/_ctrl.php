<?php
$path = $ctrl->get_path();
$path = explode('/', $path);
array_shift($path);
$path = implode('/', $path);
if ( $m = $ctrl->get_plugin_model($path, $ctrl->post) ){
  $ctrl->obj = $m;
  return false;
}
return true;