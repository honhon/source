<?php
class MobileFilterComponent {
	public function startup(&$controller) {
//		mb_convert_variables('UTF-8', 'SJIS', $controller->params['pass']);
	}
	public function shutdown(&$controller) {
		ini_set('mbstring.http_output', 'pass');
		header('Content-Type: text/html; charset="Shift-JIS"');
		$output = $controller->output;
		$output = preg_replace('/[\x00-\x1F\x7F]/ims', '', $output);
//		$output = preg_replace('/>[\x00-\x1F\x7F\x20]+</ims', '><', $output);
		$controller->output = mb_convert_encoding($output, 'SJIS', 'UTF-8');
	}
}
?>