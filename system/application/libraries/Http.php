<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Http 
    {
        public $target;     // Url Target
        public $schema;     // Schema Of Url Target
        public $host;       // Host of Url Target
        public $port;       // Port of Url Target
        public $path;       // Path of Url Target
        public $method;     // Method Of Url Target (POST/GET/PUT)
        public $cookie;     // Requested Cookie
        public $headers;    // Requested Header
        public $params;     // Request Parameters
        public $rawPost;    // Raw Post data
        public $userAgent;  // Browser Requested
        public $timeout;    // Number Timeout by second
        public $useCurl;    // Use Curl to send request, if no, fsockopen will be used to do it
        public $authUsername;   // Authentication User
        public $authPassword;   // Authentication Password
        public $proxyIp;        // Proxy IP, Can use when you used Curl
        public $proxyUsername;  // Proxy user
        public $proxyPassword;  // Proxy password
        public $isMultipart;    // Is Request Multi Part
        public $mimeContentType;// Enctype (application/x-www-form-urlencoded)
        public $boundary;       // Boundary name, use when upload file
        public $errors;         // Error while execute
        protected $_responseStatus; // Response status code
        protected $_responseCookie; // Cookies retrieved from response
        protected $_responseHeaders;// Header response
        protected $_responseText;   // Html results fetched from response
        
        public function __construct(){
                $this->reset();
        }
        
        /*
         * Reset request
         * return this
         */
        public function reset()
        {
            $this->target           = '';
            $this->schema           = 'http';
            $this->host             = '';
            $this->port             = 0;
            $this->path             = '';
            $this->method           = 'GET';
            $this->params           = array();
            $this->rawPost          = '';
            $this->cookie           = '';
            $this->headers          = array();

            $this->useCurl          = false;		
            $this->timeout          = 10; // 10 seconds	
            $this->userAgent        = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1'; // Browser Send
            $this->errors           = array();

            $this->mimeContentType  = 'application/x-www-form-urlencoded';
            $this->boundary         = 'thehalfheart';

            $this->proxyIp          = '';
            $this->proxyUsername    = '';
            $this->proxyPassword    = '';

            $this->authUsername     = '';
            $this->authPassword     = '';

            $this->_responseStatus  = 0;
            $this->_responseHeaders = array();
            $this->_responseCookie  = '';
            $this->_responseText    = '';
            
            return $this;
        }
        
        /*
         * Set url target
         * @param string
         * @return this
         */
        public function setTarget($target)
        {
            $this->target = trim($target);  
            return $this;  
        }
        
        /**
	 * Set request parameters from ($name, $value) or from array name-value pairs
	 *
	 * @param	string|array	
	 * @param	mixed
	 * @return      this
	*/
        public function setParam($name, $value = NULL)
        {
            if(func_num_args() == 2) {
                $this->params[$name] = $value;
            }
            else
            {
                if(is_array($name)) {
                    foreach($name as $key => $value) {
                        $this->params[$key] = $value;
                    }
                }
                else if(is_string($name)) {
                    $str = preg_replace_callback('#&[a-z]+;#', function($match){
                        return rawurlencode($match[0]);
                    }, $name);
                    parse_str(str_replace('+', '%2B', $str), $array);
                    $this->setParam($array);
                }
            }
        }
        
        /**
	 * Set referer
	 * @param	string
	 * @return	this
	*/
	public function setReferer($referer)
	{
		$this->headers['Referer'] = $referer;
		return $this;
	}
        
        /**
	 * Set user agent 
	 * Mozilla/5.0 (Windows NT 6.1; WOW64; rv:2.0) Gecko/20100101 Firefox/4.0
	 *
	 * @param string
	 * @return this
	*/
	public function setUserAgent($userAgent)
        {
            $this->userAgent = $userAgent;  
            return $this;  
        }
        
        /**
	 * Set number of seconds to time out
	 *
	 * @param integer seconds to time out
	 * @return this
	*/
	public function setTimeout($seconds)
        {
            if ($seconds > 0)
            {
                $this->timeout = $seconds;
            }   
            return $this;  
        }
        
        
        /**
	 * @param	string
	 * @return	this
	*/
	public function setRawPost($rawPost)
	{
		$this->rawPost = $rawPost;
		return $this;  
	}
        
        /**
	 * Request method
	 *
	 * @param	string
	 * @return	this
	*/
	public function setMethod($method)
        {
            $this->method = strtoupper(trim($method)); 
            return $this;  
        }
        
        /**
	 * Set request headers from ($name, $value) or from array name-value pairs
	 * 
	 * @param	string|array
	 * @param	mixed
	 * @return 	this
	*/
	public function setHeader($name, $value = NULL)
	{
            if(func_num_args() == 2) {
                $this->headers[trim($name)] = trim($value);
            }
            else 
            {
                if(is_array($name)) 
                {
                    foreach($name as $key => $value) 
                    {
                        if( ! is_int($key)) {
                            $this->setHeader($key, $value);
                        }
                        else {
                            $this->setHeader($value);
                        }
                    }
                }
                else if(is_string($name)) {
                    list($key, $value) = explode(':', $name, 2);
                    $this->setHeader($key, $value);
                }
            }
            return $this;  
	}
        
        /**
	 * Use cURL for sending request, otherwise use fsockopen
	 *
	 * @param boolean
	 * @return this
	*/
	public function useCurl($useCurl)
	{
            $this->useCurl = (boolean) $useCurl;
            return $this;  
	}
        
        /**
	 * @return this
	*/
	public function setSubmitMultipart($type = 'form-data') 
	{
            $this->setMethod('POST');
            $this->isMultipart = true;
            $this->mimeContentType = "multipart/" . $type;	
            return $this;
	}
        
        /**
	 * @return this
	*/
	public function setSubmitNormal($method = 'POST')
	{
		$this->setMethod($method);
		$this->isMultipart = false;
		$this->mimeContentType = "application/x-www-form-urlencoded";
		return $this;
	}
        
        /**
	 * 
	 * @param string
	 * @return this
	*/
	public function setMimeContentType($mimeType)
	{
		$this->mimeContentType = $mimeType;
		return $this;  
	}
        
        /**
	 * Set request cookie from string or array cookies
	 *
	 * @param	string|array
	 * @param	boolean	addition to existing cookie ?
	 * @return 	this
	*/
	public function setCookie($value, $addition = true)
	{
		if(is_array($value)) {
			$value = implode(';', $value);
		}
		if($addition) {
			$this->cookie .= $value . ';';
		}
		else {
			$this->cookie = $value;
		}
		return $this;
	}
        
        /**
	 * Set proxy
	 * @return 	this
	*/
	public function setProxy($proxyIp, $username = '', $password = '')
	{
		$this->proxyIp 		= $proxyIp;
		$this->proxyUsername    = $username;
		$this->proxyPassword 	= $password;
		
		return $this;
	}
        
        /**
	 * Set auth
	 * @return 	this
	*/
	public function setAuth($username, $password = '')
	{
		$this->authUsername 	= $username;
		$this->authPassword 	= $password;
		
		return $this;
	}
        
        /**
	 * Execute request 
	 *
	 * @return	string|boolean - Response text or FALSE if request failed
	*/
	public function execute($target = NULL, $method = NULL, $params = NULL, $referer = NULL)
	{
		if($target) {
			$this->setTarget($target);
		}
		if($method) {
			$this->setMethod($method);
		}
		if($referer) {
			$this->setReferer($referer);
		}
		if($params) {
			$this->setParam($params);
		}
		
		if(empty($this->target)) {
			$this->errors[] = 'ERROR: Target url must be no empty';
			return false;
		}
		
		if($this->params && $this->method == 'GET') {
			$this->target .= ($this->method == 'GET' ? (strpos($this->target, '?') ? '&' : '?') . http_build_query($this->params) : '');
		}
		
		$urlParsed = parse_url($this->target);
		
		if ($urlParsed['scheme'] == 'https') {
                        $this->host = 'ssl://' . $urlParsed['host'];
                        $this->port = ($this->port != 0) ? $this->port : 443;
                }
                else {
                    $this->host = $urlParsed['host'];
                    $this->port = ($this->port != 0) ? $this->port : 80;
                }
                $this->path   = (isset($urlParsed['path']) ? $urlParsed['path'] : '/') . (isset($urlParsed['query']) ? '?' . $urlParsed['query'] : '');
                $this->schema = $urlParsed['scheme'];
		
		
		//use curl to send request
		if($this->useCurl) 
                {
			if($this->isMultipart) {
				foreach((array)$this->params as $key => $value) {
					if(substr($value, 0, 1) == '@') {
						$this->params[$key] = $value . ';type=' . $this->_getMimeType(substr($value, 1));
					}
				}
			}
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->target);
																
			if($this->isMultipart) {
				$this->headers[] = 'Content-Type: ' . $this->mimeContentType;
			}
			if($this->method == 'POST') {
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $this->params);
			}	
			if($this->cookie) {
				curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
			}
			/*if( ! empty($this->referer['Referer'])) {
				curl_setopt($ch, CURLOPT_REFERER, $this->referer['Referer']);
			}
			*/
			if($this->headers) {
				$_headers = array();
				foreach($this->headers as $name => $value) {
					$_headers[] = $name . ': ' . $value;
				}
				curl_setopt($ch, CURLOPT_HTTPHEADER, $_headers);
			}
			if($this->timeout) {
				curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout); 
			}
			if ($this->authUsername) {
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($ch, CURLOPT_USERPWD, $this->authUsername . ':' . $this->authPassword);
			}
			if($this->proxyIp) {
				curl_setopt($ch, CURLOPT_PROXY, $this->proxyIp);	
				curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5); 		
                                
				if($this->proxyUsername) {

					curl_setopt($ch, CURLOPT_PROXYUSERPWD, 	$this->proxyUsername . ':' . $this->proxyPassword);
				}
			}
			curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
			curl_setopt($ch, CURLOPT_HEADER, true);	
			curl_setopt($ch, CURLOPT_NOBODY, false);
			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');	
			
			$response = curl_exec($ch);
			
			if($response === false) {
				$this->errors[] = 'ERROR: ' . curl_errno($ch)  . ' - ' . curl_error($ch);
				return false;
			}
			$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$responseHeader = substr($response, 0, $headerSize);
			$responseBody = substr($response, $headerSize);
			
			$this->_parseResponseHeaders($responseHeader);
			$this->_responseText = $responseBody;
			curl_close($ch);
		}
		//use fsockopen to send request
		else
		{			
			$postData = '';
			if($this->rawPost) {
				$postData .= $this->isMultipart ? "--" . $this->boundary . "\r\n" : "";
				$postData .= $this->rawPost . "\r\n";
			}
			//for upload file
			if($this->isMultipart) 
                        {
				foreach($this->params as $key => $value) 
                                    {
					if(substr($value, 0, 1) == '@') {
						$upload_file_path  = substr($value, 1);
						$upload_field_name = $key;
						
						if(file_exists($upload_file_path)) {
							$postData .= "--" . $this->boundary . "\r\n";
							$postData .= "Content-disposition: form-data; name=\"" . $upload_field_name . "\"; filename=\"" . basename($upload_file_path) . "\"\r\n";
							$postData .= "Content-Type: " . $this->_getMimeType($upload_file_path) . "\r\n";
							$postData .= "Content-Transfer-Encoding: binary\r\n\r\n";
							$postData .= $this->_readBinary($upload_file_path) . "\r\n";
						}			
					}
					else {
						$postData .= "--" . $this->boundary . "\r\n";
						$postData .= "Content-Disposition: form-data; name=\"" . $key . "\"\r\n";
						$postData .= "\r\n";
						$postData .= $value . "\r\n";
					}
				}
				$postData .= "--" . $this->boundary . "--\r\n";
			}
			//submit normal
			else
			{
				foreach($this->params as $key => $param) {
					$postData .= urlencode($key) . '=' . rawurlencode($param) . '&';
				}
			}
			//open connection
			$filePointer = @fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout); 
			
			if ( ! $filePointer) {
                            $this->errors[] = 'ERROR: ' . $errno . ' - ' . $errstr;
                            return false;
                        }
			$requestHeader  = $this->method . " " . $this->path . " HTTP/1.1\r\n";
			$requestHeader .= "Host: " . $urlParsed['host'] . "\r\n";
			$requestHeader .= "User-Agent: " . $this->userAgent . "\r\n";
			if($this->headers) {
				foreach($this->headers as $name => $value) {
					$requestHeader .= $name . ': ' . $value . "\r\n";
				}
			}
			if($this->mimeContentType) {
				$requestHeader .= "Content-Type: " . $this->mimeContentType . ($this->isMultipart ? "; boundary=" . $this->boundary : "") . "\r\n";
			}
			if($this->authUsername) {
				$requestHeader .= "Authorization: Basic " . base64_encode($this->authUsername . ":" . $this->authPassword) . "\r\n";
			}
			if($this->cookie) {
				$requestHeader .= "Cookie: " . $this->cookie . "\r\n";
			}
			if($postData && $this->method == 'POST') {
				$requestHeader .= "Content-length: " . strlen($postData) . "\r\n";
			}
			$requestHeader .= "Connection: close\r\n";
			$requestHeader .= "\r\n";
			
			if($postData && $this->method == "POST") {
				$requestHeader .= $postData;
			}
			$requestHeader .=  "\r\n\r\n";
			fwrite($filePointer, $requestHeader);
			
			$responseHeader = '';
			$responseBody = '';
			do {
				$responseHeader .= fgets($filePointer, 128);
			}
			while(strpos($responseHeader, "\r\n\r\n") === false);
			
			$this->_parseResponseHeaders($responseHeader);
			
			while (!feof($filePointer)) {
				$responseBody .= fgets($filePointer, 128);
			}
			if (isset($this->_responseHeaders['transfer-encoding']) AND $this->_responseHeaders['transfer-encoding'] == 'chunked') {
				$data = $responseBody;
				$pos = 0;
				$len = strlen($data);
				$outData = '';
				
				while ($pos < $len)  {
					$rawnum = substr($data, $pos, strpos(substr($data, $pos), "\r\n") + 2);
					$num = hexdec(trim($rawnum));
					$pos += strlen($rawnum);
					$chunk = substr($data, $pos, $num);
					$outData .= $chunk;
					$pos += strlen($chunk);
				}
				$responseBody = $outData;
			}
			$this->_responseText = ($responseBody); //ltrim
			fclose($filePointer);
		}
		
		return $this;
	}
        
        /** 
	 * Parser response headers
	 *
	 * @param	string
	 * @return 	void
	*/
	protected function _parseResponseHeaders($headers)
	{
		$this->_responseHeaders = array();
		$lines = explode("\n", $headers);
		foreach($lines as $line) {
			if($line = trim($line)) {
				// parse headers to array
				if(empty($this->_responseHeaders)) {
					preg_match('#HTTP/.*?\s+(\d+)#', $line, $match);
					$this->_responseStatus = intval($match[1]);
					$this->_responseHeaders['status'] = $line;
				}
				else if(strpos($line, ':')) {
					list($key, $value) = explode(':', $line, 2);
					$value = ltrim($value);
					$key = strtolower($key);
					//parse cookie
					if($key == 'set-cookie') {
						$this->_responseCookie .= $value . ';';
					}
					if(array_key_exists($key, $this->_responseHeaders)) {
						if( ! is_array($this->_responseHeaders[$key])) {
							$temp = $this->_responseHeaders[$key];
							unset($this->_responseHeaders[$key]);
							$this->_responseHeaders[$key][] = $temp;
							$this->_responseHeaders[$key][] = $value;
						}
						else {
							$this->_responseHeaders[$key][] = $value;
						}
					}
					else {
						$this->_responseHeaders[$key] = $value;
					}
				}
			}
		}
	}
        
        /**
	 * Get response status code
	 *
	 * @return	integer
	*/
	public function getResponseStatus()
	{
		return $this->_responseStatus;
	}
        
        /**
	 * Get response cookie 
	 *
	 * @return	string
	*/
	public function getResponseCookie()
	{
		return $this->_responseCookie;
	}
        
        /**
	 * Get response headers
	 *
	 * @param	string|null		NULL to get all headers
	 * @return	mixed|boolean	FALSE if get header by name and it is not exist
	*/
	public function getResponseHeaders($name = NULL)
	{
		if($name !== NULL) {
			if(array_key_exists($name, $this->_responseHeaders)) {
				return $this->_responseHeaders[$name];
			}
			return false;
		}
		return $this->_responseHeaders;
	}
        
        /**
	 * Get response body text
	 * 
	 * @return	string
	*/
	public function getResponseText()
	{
		return $this->_responseText;
	}
	
        public function __toString()
	{
		return $this->getResponseText();
	}
        
        /**
	 * Read binary of file for uploading.
	 *
	 * @return	string
	*/
        protected function _readBinary($filePath)
	{
		$binarydata = '';
		if(file_exists($filePath)) {
			$handle = fopen($filePath, "rb");
			while ($buff = fread($handle, 128)) {
				$binarydata .= $buff;
			}
			fclose($handle);
		}
		return $binarydata;
	}
        
        /**
	 * Get mime type of file 
	 *
	 * @param	string	file path
	 * @return	string|boolean FALSE if mime type not found
	*/
	protected function _getMimeType($filePath)
	{
		$filename = realpath($filePath);
		$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

		if (preg_match('/^(?:jpe?g|png|[gt]if|bmp|swf)$/', $extension)) {
			$file = getimagesize($filename);

			if (isset($file['mime'])) {
				return $file['mime'];
			}
		}
		if (class_exists('finfo', FALSE)) {
			if ($info = new finfo(defined('FILEINFO_MIME_TYPE') ? FILEINFO_MIME_TYPE : FILEINFO_MIME)) {
				return $info->file($filename);
			}
		}
		if (ini_get('mime_magic.magicfile') AND function_exists('mime_content_type')) 	{
			return mime_content_type($filename);
		}
		
		return false;
	}
    }
?>
