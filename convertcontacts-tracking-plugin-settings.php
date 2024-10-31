<?php

add_action('admin_menu', 'convertcontacts_add_admin_menu');
add_action('admin_init', 'convertcontacts_settings_init');

function convertcontacts_add_admin_menu() {
  add_menu_page('ReachLocal Tracking Code', 'ConvertContacts Tracking Code', 'administrator', __FILE__, 'convertcontacts_options_page');
}

function convertcontacts_settings_init() {
  register_setting('convertcontacts_settings', 'convertcontacts_tracking_code_id', 'validate_tracking_code_id');

  add_settings_section(
    'convertcontacts_tracking_code_section',
    __('ReachLocal Tracking Code', 'wordpress'), 
    'convertcontacts_settings_section_callback',
    'convertcontacts_settings'
  );

  add_settings_field( 
    'convertcontacts_tracking_code_id',
    __('ID', 'wordpress'), 
    'convertcontacts_tracking_code_id_render',
    'convertcontacts_settings',
    'convertcontacts_tracking_code_section'
  );
}


function convertcontacts_settings_section_callback() {
?>
  <p>Need help finding your ConvertContacts Site ID?</p>
  <ol>
    <li>Sign into ConvertContacts.</li>
    <li>Navigate to Settings tab, and click on 'Tracking Code'.</li>
    <li>Copy the Tracking Code ID out of your tracking code snippet. It should look something like: d4098273-6c87-4672-9f5e-94bcabf5597a <strong>Note:</strong> Do not use the example tracking code id as it will not work properly.</li>
  </ol>
  <p>If you have difficulty with this step or cannot find your Tracking ID, please contact your ConvertContacts account representative.</p>
<?php
}

function convertcontacts_tracking_code_id_render() {
  echo '<input name="convertcontacts_tracking_code_id" id="convertcontacts_tracking_code_id" class="regular-text code" type="text" value="' . get_option('convertcontacts_tracking_code_id') . '" />';
}

function convertcontacts_options_page() {
?>
  <form action='options.php' method='post'>
    
<?php
    settings_fields('convertcontacts_settings');
    settings_errors('general');
    do_settings_sections('convertcontacts_settings');
    submit_button();
?>
    
  </form>
<?php
}

function validate_tracking_code_id($guid) {
  if (empty($guid) || preg_match('/^[A-Z0-9]{8}(-[A-Z0-9]{4}){3}-[A-Z0-9]{12}$/i', $guid)) {
    return $guid;
  }

  add_settings_error(
    'general',
    'invalid-tracking_code_id',
    'Tracking code ID is invalid.',
    'error'
  );

  return get_option('convertcontacts_tracking_code_id') ? get_option('convertcontacts_tracking_code_id' ) : '';
}
