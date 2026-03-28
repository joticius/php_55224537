<?php

class AcronimoModel {

    
    public function convertirAcronimo(string $frase): string {
        
        $frase = str_replace('-', ' ', $frase);

        
        $frase = preg_replace("/[^a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/u", '', $frase);

        
        $palabras = preg_split('/\s+/', trim($frase));

        
        $acronimo = '';
        foreach ($palabras as $palabra) {
            if (!empty($palabra)) {
                $acronimo .= mb_strtoupper(mb_substr($palabra, 0, 1, 'UTF-8'), 'UTF-8');
            }
        }

        return $acronimo;
    }
}
