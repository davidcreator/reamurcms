<?php
namespace Reamur\System\Library\Language;

class Detect {
    /**
     * Get language based on browser settings
     *
     * @param array $available_languages Available language codes
     * @return string Language code
     */
    public function getLanguage(array $available_languages = ['en-gb', 'pt-br']): string {
        $default_language = 'en-gb';
        
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $browser_languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            
            foreach ($browser_languages as $browser_language) {
                // Remove quality value if present
                $lang_code = strtolower(substr($browser_language, 0, 2));
                
                // Check for pt-br specifically
                if ($lang_code === 'pt' && strpos($browser_language, 'BR') !== false) {
                    if (in_array('pt-br', $available_languages)) {
                        return 'pt-br';
                    }
                }
                
                // Match language code with available languages
                foreach ($available_languages as $available_language) {
                    if (strpos($available_language, $lang_code) === 0) {
                        return $available_language;
                    }
                }
            }
        }
        
        return $default_language;
    }
}