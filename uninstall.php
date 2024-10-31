<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
  exit;
}

delete_option('convertcontacts_tracking_code_id');
