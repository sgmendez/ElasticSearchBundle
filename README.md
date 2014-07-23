ElasticSearchBundle
===============

Integración de ElasticSearch como bundle de Symfony2

## Instalación

Hacer el require del paquete en el fichero `composer.json` del proyecto:


``` json
{
    "autoload": {
        "psr-0": { "": "src/" },
        "classmap": ["vendor/psd/elasticsearch"]
    }
    //...
    "require": {
        "psd/elasticsearch": "*"
    }
    //...
    
}
```

Registrar el bundle en el Kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new PSD\Bundle\ElasticSearchBundle\ElasticSearchBundle(),
        // ...
    );
}
```

Estableder la configuración en el fichero config.yml para definir los servicios, se pueden definir multiples conexiones
para acceder la conexión con1 usar `couchbase.con1` según lo establecido en la configuración:

```yaml
elastic_search:
    conexiones:
        con1:
          host: localhost:9200
```