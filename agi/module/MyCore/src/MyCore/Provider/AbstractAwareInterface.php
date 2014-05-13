<?php
// alter template for Skeleton Generator!!!!
namespace Mycore\Provider;

interface AbstractAwareInterface
{

    function getCurrentNamespaceforTraits(); // should be as "return __NAMESPACE__;" in every class implementing it
    function getCurrentClassforTraits(); // should be as "return __CLASS__;" in every class implementing it
                                             // there is no way knowing class & namespace names from within trait defined method
                                             // so we should be implementing these
}
