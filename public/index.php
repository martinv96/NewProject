<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

// Définir la limite de mémoire ici
ini_set('memory_limit', '1G'); // Ajustez la limite selon vos besoins
ini_set('max_execution_time', '60'); // par exemple, passer de 30 à 60 secondes


return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
