<?php
namespace Did\VpbxEnv\Model;

use Did\Gizzle\ApiGatewayInterface;
  
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
				'name' => $vpbxenv->name,
				'description' => $vpbxenv->description,
				'remotevpbxid' => $vpbxenv->remotevpbxid,
				'created' => $vpbxenv->created,
				'expiry' => $vpbxenv->expiry,
				'did' => $vpbxenv->did				
 		);
		
		$id = (int)$vpbxenv->id;
		if ($id == 0) {
			$entity = $this->apiGateway->create($data);
			$return = $entity->getId();
		} else {
			if ($this->getVpbxEnv($id)) {
				$this->apiGateway->update($data);
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