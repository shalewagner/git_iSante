<?php

require_once 'Net/HL7/Message.php';

/**
 * Usage:
 * <code>
 *
 * $conn = new Net_HL7_HohConnection ('url');
 *
 * $req = new Net_HL7_Message ();
 *
 * ... set some request attributes
 *
 * $res = $conn->send ($req);
 * </code>
 *
 * The Net_HL7_HohConnection object represents an "HL7 over HTTP (HoH)"
 * connection to an HTTP(S) server utilizing HAPI for message receipt.
 * The Connection has only one useful method (apart from the constructor):
 * 'send'. The send method takes a Net_HL7_Message object as argument, and
 * also returns a Net_HL7_Message object.
 *
 * @version    0.1
 * @author     J. Sibley <jsibley@uw.edu>
 * @access     public
 * @category   Networking
 * @package    Net_HL7
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 */
class Net_HL7_HohConnection {

    var $_MESSAGE_SUFFIX = undef;
    var $curl_handle = undef;
    var $url = undef;
    var $secure = undef;
    // HAPI expects a header like this
    var $headers = array ("Content-type: application/hl7-v2; charset=UTF-8");

    /**
     * Prepares metadata for HoH connection
     *
     * @param url Host to connect to
     * @return boolean
     */
    public function __construct ($url)
    {
        $this->url = $url;
        if (stripos ($this->url, "https://") !== false) {
          $this->secure = true;
        } else {
          $this->secure = false;
        }
        $this->curl_handle = curl_init ();
        curl_setopt ($this->curl_handle, CURLOPT_URL, $this->url);
        curl_setopt ($this->curl_handle, CURLOPT_HEADER, 0);
        curl_setopt ($this->curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($this->curl_handle, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt ($this->curl_handle, CURLOPT_TIMEOUT, 60);
        curl_setopt ($this->curl_handle, CURLOPT_HTTPHEADER, $this->headers);
        if ($secure) {
          curl_setopt ($this->curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
          curl_setopt ($this->curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
        }
        $this->_MESSAGE_SUFFIX = "\012";

        return true;
    }

    /**
     * Sends a Net_HL7_Message object over this connection.
     *
     * @param object Instance of Net_HL7_Message
     * @return boolean success
     *         object Instance of Net_HL7_Message (or error message if !success)
     * @access public
     * @see Net_HL7_Message
     */
    function send ($req)
    {
        $hl7Msg = $req->toString ();

        curl_setopt ($this->curl_handle, CURLOPT_POSTFIELDS, $hl7Msg . $this->_MESSAGE_SUFFIX);
        $res = curl_exec ($this->curl_handle);

        if (curl_getinfo ($this->curl_handle, CURLINFO_HTTP_CODE) == "200" && $res !== false) {
          $success = true;
          $resp = new Net_HL7_Message ($res);
        } else {
          $success = false;
          $resp = "HTTP CODE: " . curl_getinfo ($this->curl_handle, CURLINFO_HTTP_CODE) . ", message: " . curl_error ($this->curl_handle);
        }

        return (array ($success, $resp));
    }
}
