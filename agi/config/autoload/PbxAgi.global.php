<?php
return array(
    'pbxagi' => array(
        'call_record_file_extension' => 'wav',
        'file_move_cmd' => 'mv',
        'peer_technology' => 'SIP',
        'pause_after_greeting' => 3,
        'digits_abort_greeting' => '01234567890',
        'extension_length' => 3,
        'greeting_wait_between_digits' => 3,  
        'post_record_command' => '/usr/bin/lame -b16 "%s" "/var/spool/asterisk/mediarepos/%s.mp3"',    
        'record_call_macro_name'=>'recordcall',
        'incoming_pstn_menu_input_total_max' => 50000,
        'incoming_pstn_menu_input_between_digits_max' => 4000,       
        'dial_call_centre_operator_duration' => 100,
        'call_forward_num_combination' => '*60*',
        'fax_receive_options' => 'ds',
        'fax_receive_num_tries'=> 3,
        'fax_receive_message_from_address' =>'kartemiev@gmail.com',
        'fax_receive_message_from_fullname'=>'Программная АТС',
        'fax_receive_message_to' => 'kartemiev@gmail.com',
     	'simulring_max_calling_duration' => 60,
    	'emailfax_bounce_unknown_user_subject' => 'невозможно отправить факс',        
    	'fax_send_max_tries' => 3,	
    	'fax_send_wait_time' => 60,
         )
     );