<?php

namespace PSD\Bundle\ElasticSearchBundle\Libs;

use PSD\Bundle\ElasticSearchBundle\Libs\ElasticSearchWrapper;

/**
 * Envoltura para ElasticSearch
 *
 * @author sgarcia
 */
class ElasticSearch extends ElasticSearchWrapper
{
    /**
     * Inicializa ElasticSearch
     * 
     * @param array $hosts
     * @param object $log
     * @param boolean $debug
     */
    public function __construct($hosts, $log, $debug) 
    {
        parent::__construct($hosts, $log, $debug);
    }
}

?>
