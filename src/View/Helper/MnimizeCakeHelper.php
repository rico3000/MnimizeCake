<?php

/*
 * (c) 2019, Enrico Nemack <mail@nemack.com>
 */
namespace MnimizeCake\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;

class MnimizeCakeHelper extends Helper{

	protected $mimeTypes = [
		'text/html',
		'text/xhtml',
	];

	public function afterLayout(){
		if(!Configure::read('debug') && in_array($this->_View->response->type(), $this->mimeTypes)) {
			$content = $this->_View->Blocks->get('content');
			$content = $this->minify($content);
			$this->_View->Blocks->set('content', $content);
		}
	}

	protected function minify($content){
        $content = preg_replace('%(?>[^\S ]\s*| \s{2,})(?=(?:(?:[^<]++| <(?!/?(?:textarea|pre)\b))*+)(?:<(?>textarea|pre)\b| \z))%ix', ' ', $content);
        return $content;
    }
}
