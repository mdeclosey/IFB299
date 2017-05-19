<?php

class DavidsException extends Exception {
	// custom string representation of object
    public function __toString() {
        return "<span style=\'font-size: 3em; color: red\"><b>DavidException:</b> " . __CLASS__ . ": [{$this->code}]: {$this->message}\n</span>";
    }
}