<?php
namespace Saas\VpbxEnv\Model;

use Saas\Gizzle\ApiGatewayInterface;
  
class VpbxEnvTable implements VpbxEnvTableInterface
{
	protected $apiGateway;
	public function __construct(ApiGatewayInterface $apiGateway)
	{
		$this->apiGateway = $apiGateway;
	}
		
	public function getVpbxEnv($id)
	{
		$id  = (int) $id;
		$row = $this->apiGateway->get($id);
		return $row;
	}
	 
	public function saveVpbxEnv(VpbxEnv $vpbxenv)
	{		
		$data = array(
				'vpbx_name' => $vpbxenv->vpbx_name,
				'vpbx_description' => $vpbxenv->vpbx_description,
				'vpbx_remotevpbxid' => $vpbxenv->vpbx_remotevpbxid,
 				'outgoingtrunk_did' => $vpbxenv->outgoingtrunk_did				
 		);
		
		$id = isset($vpbxenv->id)?(int)$vpbxenv->id:0;
		if ($id == 0) {
 			$entity = $this->apiGateway->create($data);
			$return = $entity->id;
		} else {
			if ($this->getVpbxEnv($id)) {
				$this->apiGateway->update($data, $id);
			} else {
				throw new \Exception('id does not exist');
			}
		}
		return (isset($return))?$return:null;
	}
		 
	public function getApiGateway()
	{
		return $this->apiGateway;	
	}
}