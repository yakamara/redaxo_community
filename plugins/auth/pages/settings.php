<?php

$info = '';
$warning = '';
$content = '';
$modules = [
//		"login"		=> array(		"key" => "login", 			"search" => "module:ycom_auth_login",			"name" => "ycom:auth - Login"),
// 		"pswchange"	=> array(		"key" => "pswchange", 		"search" => "module:ycom_auth_pswchange",		"name" => "ycom:auth - Change Password"),
// 		"profilechange"	=> array(	"key" => "profilechange", 	"search" => "module:ycom_auth_profilechange",	"name" => "ycom:auth - Profile"),
];

$table = rex_yform_manager_table::get('rex_ycom_user');

if (rex_request('func', 'string') == 'update') {
    $this->setConfig('auth_active', rex_request('auth_active', 'int'));
    $this->setConfig('article_id_jump_ok', rex_request('article_id_jump_ok', 'int'));
    $this->setConfig('article_id_jump_not_ok', rex_request('article_id_jump_not_ok', 'int'));
    $this->setConfig('article_id_jump_logout', rex_request('article_id_jump_logout', 'int'));
    $this->setConfig('article_id_jump_denied', rex_request('article_id_jump_denied', 'int'));
    $this->setConfig('article_id_jump_password', rex_request('article_id_jump_password', 'int'));
    $this->setConfig('article_id_jump_termofuse', rex_request('article_id_jump_termofuse', 'int'));
    $this->setConfig('article_id_login', rex_request('article_id_login', 'int'));
    $this->setConfig('article_id_register', rex_request('article_id_register', 'int'));
    $this->setConfig('article_id_password', rex_request('article_id_password', 'int'));
    $this->setConfig('auth_rule', rex_request('auth_rule', 'string'));
    $this->setConfig('login_field', stripslashes(str_replace('"', '', rex_request('login_field', 'string'))));

    echo rex_view::success($this->i18n('ycom_auth_settings_updated'));
}

$sel_userfields = new rex_select();
$sel_userfields->setName('login_field');
$sel_userfields->setSize(1);

$sel_userfields->addOption('id', 'id');
$sel_userfields->addOption('email', 'email');
$sel_userfields->addOption('login', 'login');

/*foreach ($table->getValueFields() as $k => $xf) {
    $sel_userfields->addOption($k, $k);
}*/

$sel_userfields->setSelected($this->getConfig('login_field'));

$sel_authrules = new rex_select();
$sel_authrules->setId('auth-rule');
$sel_authrules->setName('auth_rule');

$rules = new rex_ycom_auth_rules();

$sel_authrules->addOptions($rules->getOptions());

$sel_authrules->setAttribute('class', 'form-control selectpicker');
$sel_authrules->setSelected($this->getConfig('auth_rule'));

$content .= '
<form action="index.php" method="post" id="ycom_auth_settings">
    <input type="hidden" name="page" value="ycom/auth/settings" />
    <input type="hidden" name="func" value="update" />


	<fieldset>
		<legend>'.$this->i18n('ycom_auth_config_status').'</legend>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-sm-push-6 abstand">
				<input class="rex-form-text" type="checkbox" id="rex-form-auth" name="auth_active" value="1" ';
if ($this->getConfig('auth_active') == '1') {
    $content .= 'checked="checked"';
}
$content .= ' />
				<label for="rex-form-auth">'.$this->i18n('ycom_auth_config_status_authactive').'</label>
			</div>
		</div>


	</fieldset>

	<fieldset>
		<legend>'.$this->i18n('ycom_auth_config_forwarder').'</legend>

		<div class="row abstand">
			<div class="col-xs-12 col-sm-6">
				<label for="rex-form-article_login_ok">'.$this->i18n('ycom_auth_config_id_jump_ok').' <small>[article_id_jump_ok]</small></label>
			</div>
			<div class="col-xs-12 col-sm-6">
				'. rex_var_link::getWidget(5, 'article_id_jump_ok', stripslashes($this->getConfig('article_id_jump_ok'))) .'
			</div>
		</div>

		<div class="row abstand">
			<div class="col-xs-12 col-sm-6">
				<label for="rex-form-article_login_failed">'.$this->i18n('ycom_auth_config_id_jump_not_ok').' <small>[article_id_jump_not_ok]</small></label>
			</div>
			<div class="col-xs-12 col-sm-6">
				'. rex_var_link::getWidget(6, 'article_id_jump_not_ok', stripslashes($this->getConfig('article_id_jump_not_ok'))) .'
			</div>
		</div>

		<div class="row abstand">
			<div class="col-xs-12 col-sm-6">
				<label for="rex-form-article_logout">'.$this->i18n('ycom_auth_config_id_jump_logout').' <small>[article_id_jump_logout]</small></label>
			</div>
			<div class="col-xs-12 col-sm-6">
				'. rex_var_link::getWidget(7, 'article_id_jump_logout', stripslashes($this->getConfig('article_id_jump_logout'))) .'
			</div>
		</div>

		<div class="row abstand">
			<div class="col-xs-12 col-sm-6">
				<label for="rex-form-article_denied">'.$this->i18n('ycom_auth_config_id_jump_denied').' <small>[article_id_jump_denied]</small></label>
			</div>
			<div class="col-xs-12 col-sm-6">
				'. rex_var_link::getWidget(8, 'article_id_jump_denied', stripslashes($this->getConfig('article_id_jump_denied'))) .'
			</div>
		</div>

		<div class="row abstand">
			<div class="col-xs-12 col-sm-6">
				<label for="rex-form-article_password">'.$this->i18n('ycom_auth_config_id_jump_password').' <small>[article_id_jump_password]</small></label>
			</div>
			<div class="col-xs-12 col-sm-6">
				'. rex_var_link::getWidget(9, 'article_id_jump_password', stripslashes($this->getConfig('article_id_jump_password'))) .'
			</div>
		</div>

		<div class="row abstand">
			<div class="col-xs-12 col-sm-6">
				<label for="rex-form-article_termofuse">'.$this->i18n('ycom_auth_config_id_jump_termofuse').' <small>[article_id_jump_termofuse]</small></label>
			</div>
			<div class="col-xs-12 col-sm-6">
				'. rex_var_link::getWidget(10, 'article_id_jump_termofuse', stripslashes($this->getConfig('article_id_jump_termofuse'))) .'
			</div>
		</div>

    </fieldset>

	<fieldset>
		<legend>'.$this->i18n('ycom_auth_config_pages').'</legend>
		
		<div class="row abstand">
			<div class="col-xs-12 col-sm-6">
				<label for="rex-form-article_login">'.$this->i18n('ycom_auth_config_id_login').' <small>[article_id_login]</small></label>
			</div>
			<div class="col-xs-12 col-sm-6">
				'. rex_var_link::getWidget(11, 'article_id_login', stripslashes($this->getConfig('article_id_login'))) .'
			</div>
		</div>

        <div class="row abstand">
			<div class="col-xs-12 col-sm-6">
				<label for="rex-form-article_register">'.$this->i18n('ycom_auth_config_id_register').' <small>[article_id_register]</small></label>
			</div>
			<div class="col-xs-12 col-sm-6">
				'. rex_var_link::getWidget(12, 'article_id_register', stripslashes($this->getConfig('article_id_register'))) .'
			</div>
		</div>

        <div class="row abstand">
			<div class="col-xs-12 col-sm-6">
				<label for="rex-form-article_password">'.$this->i18n('ycom_auth_config_id_password').' <small>[article_id_password]</small></label>
			</div>
			<div class="col-xs-12 col-sm-6">
				'. rex_var_link::getWidget(13, 'article_id_password', stripslashes($this->getConfig('article_id_password'))) .'
			</div>
		</div>

	</fieldset>

	<fieldset>
		<legend>'.$this->i18n('ycom_auth_config_login_field').'</legend>
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				'.$this->i18n('ycom_auth_config_login_field').'
			</div>
			<div class="col-xs-12 col-sm-6">
			 	<div class="select-style">
	              	'.$sel_userfields->get().'
			  	</div>
			</div>
		</div>
	</fieldset>

    <fieldset>
            <legend>'.$this->i18n('ycom_auth_config_security').'</legend>
    
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <label for="auth_rules_select">' . $this->i18n('ycom_auth_config_auth_rules') . '</label>
                </div>
                <div class="col-xs-12 col-sm-6">
                '.$sel_authrules->get().'
            </div>
        </div>
    </fieldset>

	<div class="row">
		<div class="col-xs-12 col-sm-6 col-sm-push-6">
			<button class="btn btn-save right" type="submit" name="config-submit" value="1" title="'.$this->i18n('ycom_auth_config_save').'">'.$this->i18n('ycom_auth_config_save').'</button>
		</div>
	</div>

	</form>

  ';

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit');
$fragment->setVar('title', $this->i18n('ycom_auth_settings'));
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');
