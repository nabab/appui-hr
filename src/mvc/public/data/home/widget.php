<?php
/* @var \bbn\Mvc\Controller $ctrl */
if ( !empty($ctrl->arguments[0]) ){
  $ctrl->data['code'] = $ctrl->arguments[0];
  $ctrl->action();
}