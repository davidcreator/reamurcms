<?php
namespace Reamur\Admin\Controller;

class base_controller extends \Reamur\System\Engine\Controller {
    protected function buildUrlParams($params = []) {
        $url = '';
        foreach ($params as $param) {
            if (isset($this->request->get[$param])) {
                $url .= '&' . $param . '=' . urlencode(html_entity_decode($this->request->get[$param], ENT_QUOTES, 'UTF-8'));
            }
        }
        return $url;
    }
}