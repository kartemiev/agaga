<?php
namespace PbxAgi\Service\ChannelVarManager;

use PbxAgi\Service\ChannelVarManager\ChannelVarManagerInterface;
use PbxAgi\Entity\CallEntityInterface;
use PAGI\Client\IClient;
use PbxAgi\Service\ClientImpl\Peer;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use PbxAgi\ChannelDescriptor\ChannelLocalDescriptor;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Filter\Boolean;
 
class ChannelVarManager implements ChannelVarManagerInterface, ServiceLocatorAwareInterface
{
    protected $agi;
    protected $extensionTable;
    protected $serviceLocator;
    protected $channelDescriptorParser;
    protected $callerTransferPermission;
    protected $calleeTransferPermission;
    public function __construct(IClient $agi, CallEntityInterface $call) {
        $this->agi = $agi;
        $this->call = $call;
    }

    protected function init()
    {
        $agi = $this->agi;       
        $originatingChannel = $agi->getVariable('ORIGINATINGCHANNEL'); 
         if ((''==$originatingChannel)||(!$originatingChannel)){  
              $blindTransfer = $agi->getVariable('BLINDTRANSFER');        
             if ((''==$blindTransfer)||(!$blindTransfer))  {                            
               $channel = $agi->getVariable('CHANNEL');
               $agi->setVariable('__ORIGINATINGCHANNEL', $channel);                
             }
              else
             {                     
                $agi->setVariable('__ORIGINATINGCHANNEL', $agi->getVariable('BLINDTRANSFER'));
             }
        }
        
    }
    public function getChannelData($variablename)
    {
       $channel = $this->agi->getVariable($variablename);               
       $channelDescriptorParser = $this->getChannelDescriptorParser();
       $channelDescriptor = $channelDescriptorParser->parse($channel);
        if ($channelDescriptor instanceof ChannelLocalDescriptor)
        {
            $channelInstance = $channelDescriptor;
        }
       return $channelInstance;                
    }
    public function getExten()
    {
        return $this->agi->getVariable('EXTEN');
    }

    
    public function getPeer()
    {
        $originatingchannel = $this
                ->agi->getVariable('ORIGINATINGCHANNEL');
    	
        if (preg_match(self::CHANNEL_NUMBER_PARSER_PATTERN, $originatingchannel, 
                $matches))
        {
            $technology = $matches[1];
            $peername = $matches[2];
         } elseif (preg_match(self::CHANNEL_NUMBER_PARSER_PATTERN_LOCAL_CHANNEL, $originatingchannel, 
                $matches))
            {
                $technology = $matches[1];
                $extenNum = $matches[2];
                $peerTable = $this->call->getPeerTable();
                $peer = $peerTable->getPeerByExtenNum($extenNum);
                if (!$peer) return null;
                $peername = $peer->name;
            } 
         $peerInstance = new Peer($technology, $peername);
         return $peerInstance;
    }
    
    public function setupOutgoingCall(CallEntityInterface $call)
    {
        $this->init();
        $agi = $this->agi;        
        $call = $this->call;
        
        $originatorPeerid = $agi->getVariable('ORIGINATOR_PEERID');
         if ((''==$originatorPeerid)||(!$originatorPeerid))
         {
            $agi->setVariable('ORIGINATOR_PEERID', $call->getCallOriginator()
            ->getId());
         }                
        $ownerPeerid = $agi->getVariable('OWNER_PEERID');        
        if ((''==$ownerPeerid)||(!$ownerPeerid))
         {
            $agi->setVariable('__OWNER_PEERID', $call->
           // owner is not gonna change in process - inherited indefinitely
            getCallOwner()
            ->getId());
          }                 
    }
    public function setCallDestinator()
    {
        $call = $this->call;
        $agi = $this->agi;
        $destinatorPeerid = $agi->getVariable('DESTINATOR_PEERID');
        if ((''==$destinatorPeerid)||(!$destinatorPeerid))
        {
            $agi->setVariable('_DESTINATOR_PEERID', $call->getCallDestinator()
                ->getId());
        }
     } 
    
    
    public function setupIncomingCallPstn(CallEntityInterface $call=null)
    {
        $this->init();
        
    }
    public function setupIncomingCallCallCentre(CallEntityInterface $call)
    {
        $this->init();        
    }
        public function setDialoutaction($action)
    {
            
    }
    
    public function setTransferContext()
    {
        $this->agi->setVariable('__TRANSFER_CONTEXT', AppConfigInterface::AST_TRANSFER_CONTEXT);
    }

    protected function getChannelDescriptorParser()
    {
        if (!$this->channelDescriptorParser)
        {
            $this->channelDescriptorParser = 
                $this->serviceLocator
                    ->get('PbxAgi\ChannelDescriptor\ChannelDescriptorParser');
        }
        return $this->channelDescriptorParser;
    }
	/**
     * @return the $serviceLocator
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

	/**
     * @param field_type $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }
    public function getUnqieId()
    {
        return $this->agi->getVariable('UNIQUEID');
    }
    public function getFaxStatus()
    {
        return $this->agi->getVariable('FAXSTATUS');
    }
    
    public function getCallerId()
    {        
        return $this->agi->getCallerId();
    }

	public function getCallerTransferPermission()
    {
        if (!$this->callerTransferPermission)
        {
            $this->callerTransferPermission = $this->agi->getVariable('CALLERTRANSFERPERMISSION');
        }        
        return (boolean)$this->callerTransferPermission;
    }

	public function getCalleeTransferPermission()
    {
        if (!$this->calleeTransferPermission)
        {
            $this->calleeTransferPermission = $this->agi->getVariable('CALLEETRANSFERPERMISSION');
        }
        return (boolean)$this->calleeTransferPermission;  
      }

	public function setCallerTransferPermission($callerTransferPermission)
    {
        
        $this->callerTransferPermission = (boolean)$callerTransferPermission;
        $this->agi->setVariable('__CALLERTRANSFERPERMISSION', (boolean)$callerTransferPermission);
        return $this;
    }

	public function setCalleeTransferPermission($calleeTransferPermission)
    {
        $this->calleeTransferPermission = (boolean)$calleeTransferPermission;
        $this->agi->setVariable('__CALLEETRANSFERPERMISSION', (boolean)$calleeTransferPermission);        
        return $this;
    }         
    public function setLanguage($language)
    {
         $this->agi->exec('Set',array("CHANNEL(language)=\"{$language}\""));
    }
    public function voiceMail($mailbox)
    {
        $result = $this->agi->exec('VoiceMail',array($mailbox));
    }
    public function initTransferContext()
    {
        return $this->agi->setVariable('__TRANSFER_CONTEXT', AppConfigInterface::ASTERISK_TRANSFER_CONTEXT_NAME);
    }
        
    public function setOriginatorType($originatortype)
    {
    	return $this->agi->setVariable('__ORIGINATOR_TYPE', $originatortype);
    }
    public function setCallIsTransfered()
    {
        $this->agi->setVariable('__CALLISTRANSFERED', 'true');
    }
    public function isTransfered()
    {    	
        $transfered = $this->agi->getVariable('CALLISTRANSFERED');
        return (isset($transfered)&&('true'==$transfered));
    }
    
    public function setRecordingForbidden()
    {
    	$this->agi->setVariable('__RECORDINGFORBIDDEN', 'true');
    }
    public function isRecordingForbidden()
    {
    	$recordingforbidden = $this->agi->getVariable('RECORDINGFORBIDDEN');
    	return (isset($recordingforbidden)&&('true'==$recordingforbidden));
    }
    
    
    public function setupRecordFilename()
    {
        $mediaFilename = md5($this->agi->getVariable('UNIQUEID').$this->agi->getVariable('CHANNEL'));
        $this->agi->setVariable('_RECORD_FILENAME', $mediaFilename);
    }
}
