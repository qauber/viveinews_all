<?php
/*

Stan Scates
blr | further

stan@sc8s.com
blrfurther.com

Basic OAuth and caching layer for Seaofclouds' tweet.js, designed
to introduce compatibility with Twitter's v1.1 API.

Version: 1.4
Created: 2013.02.20

https://github.com/seaofclouds/tweet
https://github.com/themattharris/tmhOAuth

 */


class ezTweet {
	/*************************************** config ***************************************/

   // Your Twitter App Consumer Key
//	private $consumer_key = 'YOUR_CONSUMER_KEY';
	private $consumer_key ;

	// Your Twitter App Consumer Secret
//	private $consumer_secret = 'YOUR_CONSUMER_SECRET';
	private $consumer_secret ;

	// Your Twitter App Access Token
//	private $user_token = 'YOUR_ACCESS_TOKEN';
	private $user_token;

	// Your Twitter App Access Token Secret
//	private $user_secret = 'YOUR_ACCESS_TOKEN_SECRET';
	private $user_secret;

	// Path to tmhOAuth libraries
	private $lib = '/lib/';

	// Enable caching
	private $cache_enabled = true;

	// Cache interval (minutes)
	private $cache_interval = 15;

	// Path to writable cache directory
	private $cache_dir;

	// Enable debugging
	private $debug = true;

	/**************************************************************************************/

	public function __construct() {
		// Initialize paths and etc.
		$this->pathify($this->cache_dir);
		$this->pathify($this->lib);
		$this->message = '';
        $this->lib = dirname(__FILE__).DIRECTORY_SEPARATOR;
        $this->cache_dir = dirname(__FILE__).DIRECTORY_SEPARATOR;

		// Set server-side debug params
		if($this->debug === true) {
			error_reporting(-1);
		} else {
			error_reporting(0);
		}
	}

    public function setCredentials(array $credentials){
       $this->consumer_key      = $credentials['consumer_key'];
	   $this->consumer_secret   = $credentials['consumer_secret'];
	   $this->user_token        = $credentials['user_token'];
	   $this->user_secret       = $credentials['user_secret'];
    }
	public function fetch() {
		echo json_encode(
			array(
				'response' => json_decode($this->getJSON(), true),
				'message' => ($this->debug) ? $this->message : false
			)
		);
	}

	private function getJSON() {
		if($this->cache_enabled === true) {
			$CFID = $this->generateCFID();
			$cache_file = $this->cache_dir.$CFID;

			if(file_exists($cache_file) && (filemtime($cache_file) > (time() - 60 * intval($this->cache_interval)))) {
				return file_get_contents($cache_file, FILE_USE_INCLUDE_PATH);
			} else {

				$JSONraw = $this->getTwitterJSON();
				$JSON = $JSONraw['response'];

				// Don't write a bad cache file if there was a CURL error
				if($JSONraw['errno'] != 0) {
					$this->consoleDebug($JSONraw['error']);
					return $JSON;
				}

				if($this->debug === true) {
					// Check for twitter-side errors
					$pj = json_decode($JSON, true);
					if(isset($pj['errors'])) {
						foreach($pj['errors'] as $error) {
							$message = 'Twitter Error: "'.$error['message'].'", Error Code #'.$error['code'];
							$this->consoleDebug($message);
						}
						return false;
					}
				}

				if(is_writable($this->cache_dir) && $JSONraw) {
					if(file_put_contents($cache_file, $JSON, LOCK_EX) === false) {
						$this->consoleDebug("Error writing cache file");
					}
				} else {
					$this->consoleDebug("Cache directory is not writable");
				}
				return $JSON;
			}
		} else {
			$JSONraw = $this->getTwitterJSON();

			if($this->debug === true) {
				// Check for CURL errors
				if($JSONraw['errno'] != 0) {
					$this->consoleDebug($JSONraw['error']);
				}

				// Check for twitter-side errors
				$pj = json_decode($JSONraw['response'], true);
				if(isset($pj['errors'])) {
					foreach($pj['errors'] as $error) {
						$message = 'Twitter Error: "'.$error['message'].'", Error Code #'.$error['code'];
						$this->consoleDebug($message);
					}
					return false;
				}
			}
			return $JSONraw['response'];
		}
	}

	private function getTwitterJSON() {
		require dirname(__FILE__).'/lib/tmhOAuth.php';
		require dirname(__FILE__).'/lib/tmhUtilities.php';

		$tmhOAuth = new tmhOAuth(array(
			'host'                  => $_POST['request']['host'],
			'consumer_key'          => $this->consumer_key,
			'consumer_secret'       => $this->consumer_secret,
			'user_token'            => $this->user_token,
			'user_secret'           => $this->user_secret,
			'curl_ssl_verifypeer'   => false
		));

		$url = $_POST['request']['url'];
		$params = $_POST['request']['parameters'];

		$tmhOAuth->request('GET', $tmhOAuth->url($url), $params);
		return $tmhOAuth->response;
	}

	private function generateCFID() {
		// The unique cached filename ID
		return md5(serialize($_POST)).'.json';
	}

	private function pathify(&$path) {
		// Ensures our user-specified paths are up to snuff
		$path = realpath($path).'/';
	}

	private function consoleDebug($message) {
		if($this->debug === true) {
			$this->message .= 'tweet.js: '.$message."\n";
		}
	}
}

//$credentials = array(
//  'consumer_key'    => array_key_exists('xxl-twitter-consumer-key',$option_data)?$option_data['xxl-twitter-consumer-key']:'',
//  'consumer_secret' => array_key_exists('xxl-twitter-consumer-secret',$option_data)?$option_data['xxl-twitter-consumer-secret']:'',
//  'user_token'      => array_key_exists('xxl-twitter-user-token',$option_data)?$option_data['xxl-twitter-user-token']:'',
//  'user_secret'     => array_key_exists('xxl-twitter-user-secret',$option_data)?$option_data['xxl-twitter-user-secret']:''
//);
//
//$ezTweet = new ezTweet;
//$ezTweet->setCredentials($credentials);
//$ezTweet->fetch();

?>
