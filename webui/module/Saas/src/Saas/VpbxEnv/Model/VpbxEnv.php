<?php
namespace Saas\VpbxEnv\Model;

use Zend\Form\Annotation as Form;

/**
 * @Form\Name("vpbxenv")
 * @Form\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 */

class VpbxEnv
{
	/**
	 * @Annotation\Exclude()
	 */
	public $vpbx_id;	
	/**
	 * @Form\Filter({"name":"StringTrim"})
	 * @Form\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
	 * @Form\Attributes({"type":"text"})
	 */
	public $vpbx_name;
	/**
	 * @Form\Filter({"name":"StringTrim"})
	 * @Form\Validator({"name":"StringLength", "options":{"min":1, "max":1024}})
	 * @Form\Attributes({"type":"text"})
	 */
	public $vpbx_description;	
	/**
	 * @Form\Filter({"name":"StringTrim"})
	 * @Form\Validator({"name":"StringLength", "options":{"min":1, "max":50}})
	 * @Form\Attributes({"type":"text"})
	 */
	public $vpbx_remotevpbxid;
	/**
	 * @Annotation\Exclude()
	 */
	public $vpbx_created;	
	/**
	 * @Annotation\Exclude()
	 */
	public $vpbx_expiry;	
	/**
	* @Form\Validator({"name":"NotEmpty", "options":{"message":"поле должно присуствовать","break_chain_on_failure":"true"}})
	**/
	public $outgoingtrunk_did;

	/**
	 * @Annotation\Exclude()
	 */
	public $outgoing_trunk_id;
	
	
	/**
	 * @Annotation\Exclude()
	 */
	public $sip_id;
		
	
	/**
	 * @Annotation\Exclude()
	 */
	public $sip_name;
	

	/**
	 * @Annotation\Exclude()
	 */
	public $sip_secret;
	
	
	public function exchangeArray($data)
	{
		$this->vpbx_id = (isset($data['vpbx_id']))? $data['vpbx_id']:null;
		$this->vpbx_name = (isset($data['vpbx_name']))? $data['vpbx_name']:null;
		$this->vpbx_description = (isset($data['vpbx_description']))? $data['vpbx_description']:null;
		$this->vpbx_remotevpbxid = (isset($data['vpbx_remotevpbxid']))? $data['vpbx_remotevpbxid']:null;
		$this->vpbx_expiry = (isset($data['vpbx_expiry']))? $data['vpbx_expiry']:null;
		$this->outgoing_trunk_id = (isset($data['outgoing_trunk_id']))? $data['outgoing_trunk_id']:null;
		$this->sip_id = (isset($data['sip_id']))? $data['sip_id']:null;		
		$this->sip_name = (isset($data['sip_name']))? $data['sip_name']:null;
		$this->sip_secret = (isset($data['sip_secret']))? $data['sip_secret']:null;
	}
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
	
}
