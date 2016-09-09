<?php

	namespace Z;
	class Log
	{
		const XML = "xml";
		const LOG = "log";
		private $type;
		private $path;
		private $filename;
		private $dated;
		private $clear;
		private $backup;
		private $date;
		private $ip;
		public function __construct($params)
		{
			$this->date     = date("Y-m-d H:i:s");
			$this->ip       = ($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 0;
			$this->type     = (isset($params["type"])) ? $params["type"] : Log::LOG;
			$this->path     = (isset($params["path"])) ? $params["path"] : "/";
			$this->dated    = (isset($params["dated"])) ? $params["dated"] : false;
			$this->clear    = (isset($params["clear"])) ? $params["clear"] : false;
			$this->backup   = (isset($params["backup"])) ? $params["backup"] : false;
			$this->filename = (isset($params["filename"])) ? $params["filename"] : "log";
		}
		public function config($params)
		{
			$this->type     = (isset($params["type"])) ? $params["type"] : $this->type;
			$this->path     = (isset($params["path"])) ? $params["path"] : $this->path;
			$this->dated    = (isset($params["dated"])) ? $params["dated"] : $this->dated;
			$this->clear    = (isset($params["clear"])) ? $params["clear"] : $this->clear;
			$this->backup   = (isset($params["backup"])) ? $params["backup"] : $this->backup;
			$this->filename = (isset($params["filename"])) ? $params["filename"] : $this->filename;
		}
		public function insert($text)
		{
			switch ($this->type) {
				case self::LOG:
					if ($this->dated) {
						$date   = "_" . str_replace(" ", "_", $this->date);
						$append = null;
					} else {
						$date   = "";
						$append = ($this->clear) ? null : FILE_APPEND;
						if ($this->backup) {
							$result = (copy($this->path . $this->filename . "." . $this->type, $this->path . $this->filename . "_" . str_replace(" ", "_", $this->date) . "-backup." . $this->type)) ? 1 : 0;
							$append = ($result) ? $result : FILE_APPEND;
						}
					};
					$log    = $this->date . " [ip] " . $this->ip . " [text] " . $text . PHP_EOL;
					$result = (file_put_contents($this->path . $this->filename . $date . "." . $this->type, $log, $append)) ? 1 : 0;
					break;
				case self::XML:
					$xml = new \DOMDocument('1.0', 'UTF-8');
					if ($this->clear) {
						if ($clear) {
							$result = (copy($this->path . $this->filename . "." . $this->type, $this->path . $this->filename . "_" . str_replace(" ", "_", $this->date) . "-backup." . $this->type)) ? 1 : 0;
						}
						$root = $xml->createElement('data');
						$root = $xml->appendChild($root);
					} else {
						$this->check_file_available($this->type);
						$xml->load($this->path . $this->filename . "." . $this->type);
					}
					$root = $xml->getElementsByTagName('data')->item(0);
					$log  = $xml->createElement('log', $text);
					$log  = $root->appendChild($log);
					$date = $xml->createAttribute('date');
					$date->appendChild($xml->createTextNode($this->date));
					$ip = $xml->createAttribute('ip');
					$ip->appendChild($xml->createTextNode($this->ip));
					$log->appendChild($date);
					$log->appendChild($ip);
					$xml->formatOutput = true;
					$xml->saveXML();
					$result = ($xml->save($this->path . $this->filename . "." . $this->type)) ? 1 : 0;
					break;
			}

			return $result;
		}
		//-----------------------------------
		public function check_file_available($type)
		{
			if (!file_exists($this->path . $this->filename . "." . $this->type)) {
				switch ($this->type) {
					case self::XML:
						$xml               = new DOMDocument('1.0', 'UTF-8');
						$root              = $xml->createElement('data');
						$root              = $xml->appendChild($root);
						$xml->formatOutput = true;
						$xml->saveXML();
						$result = ($xml->save($this->path . $this->filename . "." . $this->type)) ? 1 : 0;
						break;
				}
			} else {
				$result = 1;
			}

			return $result;
		}
	}