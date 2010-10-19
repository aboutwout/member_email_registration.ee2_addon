<?php

/**
* @package ExpressionEngine
* @author Wouter Vervloet
* @copyright  Copyright (c) 2010, Baseworks
* @license    http://creativecommons.org/licenses/by-sa/3.0/
* 
* This work is licensed under the Creative Commons Attribution-Share Alike 3.0 Unported.
* To view a copy of this license, visit http://creativecommons.org/licenses/by-sa/3.0/
* or send a letter to Creative Commons, 171 Second Street, Suite 300,
* San Francisco, California, 94105, USA.
* 
*/

if ( ! defined('EXT')) { exit('Invalid file request'); }

class Member_email_registration_ext
{
  public $settings            = array();
  
  public $name                = 'Member Email Registration';
  public $version             = 0.9;
  public $description         = "Allow members to register their e-mail address as their username.";
  public $settings_exist      = 'n';
  public $docs_url            = '';
  			
	// -------------------------------
	// Constructor
	// -------------------------------
	function Member_email_registration_ext($settings='')
	{
	  $this->__construct($settings);
	}
	
	function __construct($settings='')
	{
	  
	  /** -------------------------------------
    /**  Get global instance
    /** -------------------------------------*/
    $this->EE =& get_instance();
	  
		$this->settings = $settings;
		
	}
	// END Member_email_registration_ext
  
  /**
   * Checks if username isn't set and if so, populate the username field with the e-mail address supplied
   * @return  void
   */  
  function member_member_register_start()
  {
    
    // If a user has been specifically set, return and let the Member module handle the rest
    if( $this->EE->input->post('username') ) return;
    
    // If no e-mail address has been set or e-mail and e-mail confirmation do not match, return and let the Member module handle the error reporting
    if( ! $this->EE->input->post('email') || $this->EE->input->post('email') != $this->EE->input->post('email_confirm') ) return;
    
    // Set the e-mail address as username
    $_POST['username'] = $_POST['email'];
    
  }
  // END	member_member_register_start	
	
	/**
   * @todo
   * @return  void
   */  
  function sessions_start($ee)
  {
/*    
    $qs = $this->EE->uri->query_string;
    if($qs != 'update_userpass' && $qs != 'update_email') return;
    
    $this->EE->session = $ee;
    
    switch($qs)
    {
      case 'update_userpass';

        if( ! $this->EE->input->post('username')) return;

        $_POST['email'] = $_POST['username'];
        $_POST['password'] = $_POST['current_password'];

        $this->_update_email();

        break;
    }
*/
    return;
  }
  // END	sessions_start
  
	
	/** ----------------------------------------
	/**  Username/Password Update
	/** ----------------------------------------*/
	function _update_userpass()
	{		
	}
	
	/** ----------------------------------------
	/**  Email Update
	/** ----------------------------------------*/
	function _update_email()
	{ 
	}
	
	
	// --------------------------------
	//  Activate Extension
	// --------------------------------
	function activate_extension()
	{

    // hooks array
    $hooks = array(
      'member_member_register_start' => 'member_member_register_start',
      'sessions_start' => 'sessions_start'
    );

    // insert hooks and methods
    foreach ($hooks AS $hook => $method)
    {
      // data to insert
      $data = array(
        'class'		=> get_class($this),
        'method'	=> $method,
        'hook'		=> $hook,
        'priority'	=> 1,
        'version'	=> $this->version,
        'enabled'	=> 'y',
        'settings'	=> ''
      );

      // insert in database
      $this->EE->db->insert('exp_extensions', $data);
    }

    return true;
	}
	// END activate_extension
	 
	 
	// --------------------------------
	//  Update Extension
	// --------------------------------  
	function update_extension($current='')
	{
  }
  // END update_extension

	// --------------------------------
	//  Disable Extension
	// --------------------------------
	function disable_extension()
	{		
    // Delete records
    $this->EE->db->where('class', get_class($this));
    $this->EE->db->delete('exp_extensions');
  }
  // END disable_extension

	 
}
// END CLASS

?>