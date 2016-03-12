<?php

namespace Z;

class Log {
	const XML = "xml";
	const LOG = "log";
	private $path;
	private $filename;
	private $date;
	private $ip;
	public function __construct($filename, $path) {
		$this->path = ($path) ? $path : "/";
		$this->filename = ($filename) ? $filename : "log";
		$this->date = date("Y-m-d H:i:s");
		$this->ip = ($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 0;
	}
	public function insert($tipo, $text, $dated, $clear, $backup) {
		switch ($tipo) {
			case self::LOG:
				if ($dated) {
					$date = "_" . str_replace(" ", "_", $this->date);
					$append = null;
				} else {
					$date = "";
					$append = ($clear) ? null : FILE_APPEND;
					if ($backup) {
						$result = (copy($this->path . $this->filename . "." . $tipo, $this->path . $this->filename . "_" . str_replace(" ", "_", $this->date) . "-backup." . $tipo)) ? 1 : 0;
						$append = ($result) ? $result : FILE_APPEND;
					}
				};
				$log = $this->date . " [ip] " . $this->ip . " [text] " . $text . PHP_EOL;
				$result = (file_put_contents($this->path . $this->filename . $date . "." . $tipo, $log, $append)) ? 1 : 0;
				break;
			case self::XML:
				$xml = new \DOMDocument('1.0', 'UTF-8');
				if ($clear) {
					if ($backup) {
						$result = (copy($this->path . $this->filename . "." . $tipo, $this->path . $this->filename . "_" . str_replace(" ", "_", $this->date) . "-backup." . $tipo)) ? 1 : 0;
					}
					$root = $xml->createElement('data');
					$root = $xml->appendChild($root);
				} else {
					$this->check_file_available($tipo);
					$xml->load($this->path . $this->filename . "." . $tipo);
				}
				$root = $xml->getElementsByTagName('data')->item(0);
				$log = $xml->createElement('log', $text);
				$log = $root->appendChild($log);
				$date = $xml->createAttribute('date');
				$date->appendChild($xml->createTextNode($this->date));
				$ip = $xml->createAttribute('ip');
				$ip->appendChild($xml->createTextNode($this->ip));
				$log->appendChild($date);
				$log->appendChild($ip);
				$xml->formatOutput = true;
				$xml->saveXML();
				$result = ($xml->save($this->path . $this->filename . "." . $tipo)) ? 1 : 0;
				break;
		}
		return $result;
	}
	//-----------------------------------
	public function check_file_available($tipo) {
		if (!file_exists($this->path . $this->filename . "." . $tipo)) {
			switch ($tipo) {
				case self::XML:
					$xml = new DOMDocument('1.0', 'UTF-8');
					$root = $xml->createElement('data');
					$root = $xml->appendChild($root);
					$xml->formatOutput = true;
					$xml->saveXML();
					$result = ($xml->save($this->path . $this->filename . "." . $tipo)) ? 1 : 0;
					break;
			}
		} else {
			$result = 1;
		}

		return $result;
	}
}