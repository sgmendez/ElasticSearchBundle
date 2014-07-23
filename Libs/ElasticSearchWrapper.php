<?php

namespace PSD\Bundle\ElasticSearchBundle\Libs;

/**
 * Wrapper for ElasticSearch
 *
 * @author sgarcia
 */
class ElasticSearchWrapper
{
    /**
     * Log de Symfony
     * 
     * @var object 
     */
    private $log;
    
    /**
     * Nivel de debug definido en el kernel de Symfony
     * 
     * @var boolean 
     */
    private $debug;
    
    /**
     * Contiene el listado de hosts de elasticsearch
     * 
     * @var string 
     */
    private $dsn;
    
    protected $elasticSearch;


    public function __construct($hosts, $log, $debug) 
    {
        $this->log = $log;
        $this->debug = $debug;
        
        if(is_string($hosts))
        {
            $hosts = array($hosts);
        }
        
        $this->dsn = implode(', ', $hosts);
        
        $params = array();
        $params['hosts'] = $hosts;
        
        try
        {
            $this->elasticSearch = new \Elasticsearch\Client($params);
        }
        catch(\Exception $e)
        {
            $this->catchException($e);
        }
    }
    
    /**
     * Manejar las excepciones generadas
     * 
     * @param object $e Exception
     * @throws NotFoundHttpException
     */
    protected function catchException($e)
    {
        $this->log->err('DSN: '.$this->dsn. '| CLASS: '.get_class($e). '| CODE: '.$e->getCode() . '| MSG: '. $e->getMessage());
        
        // Si el debug de Symfony está activo, levantamos una excepcion
        if($this->isDebugActive())
        {
            throw new NotFoundHttpException($e->getMessage(), $e, $e->getCode());
        }
        
        //Generamos un objeto JSON vacio para retornar en producción
        return json_encode(new \stdClass);
    }
    
    /**
     * Envoltura de los metodos de ElasticSearch
     * 
     * @param string $name
     * @param array $arguments
     * @return type
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {        
        try
        {
            if(!method_exists($this->elasticSearch, $name))
            {
                throw new \Exception('En ElasticSearch no existe el metodo: ' . $name);
            }
            
            $resultado = call_user_func_array(array($this->elasticSearch, $name), $arguments);
        }
        catch (\Exception $e) 
        {
            $resultado = $this->catchException($e);
        }
        
        return $resultado;
    }  
}

?>
