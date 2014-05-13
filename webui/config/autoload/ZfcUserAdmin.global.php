<?php
/**
 * ZfcUserAdmin Configuration
 *
 * If you have a ./config/autoload/ directory set up for your project, you can
 * drop this config file in it and change the values as you wish.
 */
$settings = array(
   'user_mapper' => 'ZfcUserAdmin\Mapper\UserZendDb',
    'user_list_elements' => array('идентификатор' => 'id', 'адрес электронной почты' => 'email'),
   // 'edit_form_elements' => array('роль' => 'role'),
  // 'create_form_elements' => array( 'роль' => 'role'),
//'пароль' => 'password'
//),
    
    'create_user_auto_password' => false

    /**
     * Mapper for ZfcUser
     *
     * Set the mapper to be used here
     * Currently Available mappers
     * 
     * ZfcUserAdmin\Mapper\UserDoctrine
     *
     * By default this is using
     * ZfcUserAdmin\Mapper\UserZendDb
     */
//    'user_mapper' => 'ZfcUserAdmin\Mapper\UserDoctrine',
);

/**
 * You do not need to edit below this line
 */
return array(
    'zfcuseradmin' => $settings
);
