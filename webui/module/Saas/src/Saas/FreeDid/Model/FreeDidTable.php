<?php
namespace Saas\FreeDid\Model;

use Saas\Gizzle\ApiGatewayInterface;
 
class FreeDidTable implements FreeDidTableInterface
{
	protected $apiGateway;
	public function __construct(ApiGatewayInterface $apiGateway)
	{
		$this->apiGateway = $apiGateway;
	}
	
	public function fetchAll($filter=null)
	{
		$resultSet = $this->apiGateway->getList($filter);	
		return $resultSet;
	}
	
	public function getDid($id)
	{
		$id  = (int) $id;
		$row = $this->apiGateway->get($id);
		return $row;
	}
	 
	public function saveDid(FreeDid $did)
	{
		$data = array(
				'didissuancepool' => $did->didissuancepool,
				'areacode' => $did->areacode,
				'digits' => $did->digits,
				'didtype' => $did->didtype,
				'status' => $did->status,
				'provider' => $did->provider,
				'providerincomingtrunk' => $did->providerincomingtrunk,
				'dateissuedtovpbx' => $did->dateissuedtovpbx,
				'dateexpiryforvpbx' => $did->dateexpiryforvpbx,
				'dateissuedbyprovider' => $did->dateissuedbyprovider,
				'dateexpiryforprovider' => $did->dateexpiryforprovider,
				'vpbx' => $did->vpbx,
				'vpbxtrunk' => $did->vpbxtrunk,
				'reservationdate' => $did->reservationdate,
				'reserveduntil' => $did->reserveduntil			 
 		);
		
		$id = (int)$did->id;
		if ($id == 0) {
			$entity = $this->apiGateway->create($data);
			$return = $entity->getId();
		} else {
			if ($this->getDid($id)) {
				$this->apiGateway->update($data, $id);
			} else {
				throw new \Exception('id does not exist');
			}
		}
		return (isset($return))?$return:null;
	}
	
	public function deleteDid($id)
	{
		$this->apiGateway->delete($id);
	}
	public function getApiGateway()
	{
		return $this->apiGateway;	
	}
}