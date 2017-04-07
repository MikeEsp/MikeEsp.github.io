<?php
class WebAPI {
	private static $instance = 0;
	private static $errors = 0;

    public $allowed_method_type;
    public $cleaned_output;
    public $results;

    public $error_code = array(
    	1 => 'ERROR'
    );

    public $httpStatusCode = array(
    	"100" => "Continue",
    	"101" => "Switching Protocols",
    	"102" => "Processing (WebDAV)",
    	"200" => "OK",
    	"201" => "Created",
    	"202" => "Accepted",
    	"203" => "Non-Authoritative Information",
    	"204" => "No Content",
    	"205" => "Reset Content",
    	"206" => "Partial Content",
    	"207" => "Multi-Status (WebDAV)",
    	"208" => "Already Reported (WebDAV)",
    	"226" => "IM Used",
    	"300" => "Multiple Choices",
    	"301" => "Moved Permanently",
    	"302" => "Found",
    	"303" => "See Other",
    	"304" => "Not Modified",
    	"305" => "Use Proxy",
    	// "306" => "(Unused)",
    	"307" => "Temporary Redirect",
    	"308" => "Permanent Redirect (experiemental)",
    	"400" => "Bad Request",
    	"401" => "Unauthorized",
    	"402" => "Payment Required",
    	"403" => "Forbidden",
    	"404" => "Not Found",
    	"405" => "Method Not Allowed",
    	"406" => "Not Acceptable",
    	"407" => "Proxy Authentication Required",
    	"408" => "Request Timeout",
    	"409" => "Conflict",
    	"410" => "Gone",
    	"411" => "Length Required",
    	"412" => "Precondition Failed",
    	"413" => "Request Entity Too Large",
    	"414" => "Request-URI Too Long",
    	"415" => "Unsupported Media Type",
    	"416" => "Requested Range Not Satisfiable",
    	"417" => "Expectation Failed",
    	"418" => "I'm a teapot (RFC 2324)",
    	"420" => "Enhance Your Calm (Twitter)",
    	"422" => "Unprocessable Entity (WebDAV)",
    	"423" => "Locked (WebDAV)",
    	"424" => "Failed Dependency (WebDAV)",
    	"425" => "Reserved for WebDAV",
    	"426" => "Upgrade Required",
    	"428" => "Precondition Required",
    	"429" => "Too Many Requests",
    	"431" => "Request Header Fields Too Large",
    	"444" => "No Response (Nginx)",
    	"449" => "Retry With (Microsoft)",
    	"450" => "Blocked by Windows Parental Controls (Microsoft)",
    	"451" => "Unavailable For Legal Reasons",
    	"499" => "Client Closed Request (Nginx)",
    	"500" => "Internal Server Error",
    	"501" => "Not Implemented",
    	"502" => "Bad Gateway",
    	"503" => "Service Unavailable",
    	"504" => "Gateway Timeout",
    	"505" => "HTTP Version Not Supported",
    	"506" => "Variant Also Negotiates (Experimental)",
    	"507" => "Insufficient Storage (WebDAV)",
    	"508" => "Loop Detected (WebDAV)",
    	"509" => "Bandwidth Limit Exceeded (Apache)",
    	"510" => "Not Extended",
    	"511" => "Network Authentication Required",
    	"598" => "Network read timeout error",
    	"599" => "Network connect timeout error"
	);

    public $response = array(
    	'status'        => 'SUCCESS',
    	'results'       => null,
    	'error'         => null,
    	'error_message' => null
   	);

	public function __construct($header_method_type){

		register_shutdown_function( self::footer() ); //old if footer is public footer

		// $temp = self;
		// register_shutdown_function( function() use ($temp){
		// 	$temp::footer();
		// });
		
		self::$instance++;
        if(self::$instance > 1) {
        	self::throwError('Only one instance of WebService class is allowed',500);
        }

        self::header($header_method_type);
	}

	private function header($header_method_type){
		header('Content-Type: application/json');
		ob_start();
		$this->allowed_method_type = $header_method_type;
		self::headerValidation();
	}

	private function headerValidation(){
		if(gettype( $this->allowed_method_type ) == "string"){
			$this->allowed_method_type = strtoupper($this->allowed_method_type);
			if( $this->allowed_method_type != $_SERVER['REQUEST_METHOD'] ){
				self::throwError($_SERVER['REQUEST_METHOD'].' method is not allowed.',405);
			}
		}else if(gettype( $this->allowed_method_type ) == "array"){
			$this->allowed_method_type = implode('|^|', $this->allowed_method_type);
			$this->allowed_method_type = strtoupper($this->allowed_method_type);
			$this->allowed_method_type = explode('|^|', $this->allowed_method_type);
			if(  count(array_filter($this->allowed_method_type)) <= 0 ){
				self::throwError('No access method set.',405);
			}
			if(  !in_array($_SERVER['REQUEST_METHOD'], $this->allowed_method_type ) ){
				self::throwError($_SERVER['REQUEST_METHOD'].' method is not allowed.',405);
			}
		}else if(gettype( $this->allowed_method_type ) == 'NULL'){
			self::throwError('No access method set.',405);
		}
	}
	
	private function throwError($message, $httpStatusCode){
		self::$errors++;
		$this->response['error'] = $this->httpStatusCode[$httpStatusCode];
		$this->response['error_message'] = $message;
		header( "HTTP/1.1 ".$httpStatusCode );
		throw new Exception;
	}

	private function footerValidation(){
		$error = error_get_last();
		if($error){
			if($error['type'] == 1){
				self::$errors++;
				$this->response['error_stack_root_trace'] = explode("\n", $error['message']); //$error['message'];
				$this->response['error_stack_root_file'] = $error['file'];
				$this->response['error_stack_root_line'] = $error['line'];
				if(gettype($this->response['error']) == 'NULL'){
					$httpStatusCode = 500;
					$this->response['error'] = $this->httpStatusCode[ $httpStatusCode ];
					header( "HTTP/1.1 ".$httpStatusCode );
				}
				if(gettype($this->response['error_message']) == 'NULL'){
					$this->response['error_message'] = 'API Service Error';
				}
			}
		}
		if(self::$errors >= 1){
			$this->response['status'] = $this->error_code[$error['type']];
			$this->response['results'] = null;
		}
	}

	private function footer($a){
		return function (){
			$this->output = ob_get_clean();
			if($this->results){
				$this->response['results'] = $this->results;
			}
			self::footerValidation();
			echo json_encode( $this->response, JSON_PRETTY_PRINT | JSON_HEX_QUOT | JSON_HEX_TAG );
		};
	}

	public function setRequiredParams(){
		$parameters = func_get_args();
		$collect_required_fields = array();
		foreach ($parameters as $parameter_name) {
			if(gettype($this->allowed_method_type) == 'array'){
				foreach ($this->allowed_method_type as $method_value) {
					if($method_value == 'POST'){
						if( !isset($_POST[$parameter_name]) || empty($_POST[$parameter_name]) ){
							array_push($collect_required_fields, $parameter_name);
						}
					}else if($method_value == 'GET'){
						if( !isset($_GET[$parameter_name]) || empty($_GET[$parameter_name]) ){
							array_push($collect_required_fields, $parameter_name);
						}
					}
				}
			}else if(gettype($this->allowed_method_type) == 'string'){
				if($this->allowed_method_type == 'POST'){
					if( !isset($_POST[$parameter_name]) || empty($_POST[$parameter_name]) ){
						array_push($collect_required_fields, $parameter_name);
					}
				}else if($this->allowed_method_type == 'GET'){
					if( !isset($_GET[$parameter_name]) || empty($_GET[$parameter_name]) ){
						array_push($collect_required_fields, $parameter_name);
					}
				}
			}
		}
		if(count($collect_required_fields) >= 1){
			$temp = $collect_required_fields[count($collect_required_fields)-1];
			unset($collect_required_fields[count($collect_required_fields)-1]);
			self::throwError('This API requires: '.(count($collect_required_fields)>=1?implode(', ', $collect_required_fields).' and ':'').$temp.' paramaters', 412 );
		}
	}

}
?>