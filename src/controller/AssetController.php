<?php

class AssetController extends Controller {
	protected $css = array(
		'fonts.css',
		'foundation.min.css',
		'style.css',
		'jQuery.dataTables.css',
	);

	protected $priorityJs = array(
		'foundation/modernizr.foundation.js'
	);

	protected $js = array(
		'vendor/jquery.min.js',
		'foundation/foundation.min.js',
		'vendor/jquery-ui.min.js',
		'vendor/jquery.dataTables.min.js',
		'vendor/jquery.highlight-4.js',
		'script.js',
		'foundation/app.js',
	);

	function __construct() {
		Layout::getInstance()->disable();
	}

	public function css() {
		header("Content-Type: text/css, charset=windows-1252");

		foreach($this->css as $url) {
			require_once('/../www/assets/css/' . $url);
			echo "\n";
		}
	}

	public function js() {
		header("Content-Type: application/javascript, charset=windows-1252");

		foreach($this->js as $url) {
			require_once('/../www/assets/js/' . $url);
			echo "\n";
		}
	}

	public function priorityJs() {
		header("Content-Type: application/javascript, charset=windows-1252");

		foreach($this->priorityJs as $url) {
			require_once('/../www/assets/js/' . $url);
			echo "\n";
		}
	}
}