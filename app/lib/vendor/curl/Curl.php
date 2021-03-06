<?php
/**
* @Copyright (C) 2015
* @Author
* @Description CURL组件
*/

namespace lib\vendor\curl;

use Yii;
use yii\base\Component;
use yii\base\Exception;
use yii\helpers\Json;
use yii\web\HttpException;

/**
 * cURL class
 */
class Curl extends Component
{
	/**
	 * @var string
	 * Holds response data right after sending a request.
	 */
	public $response = null;

	/**
	 * @var integer HTTP-Status Code
	 * This value will hold HTTP-Status Code. False if request was not successful.
	 */
	public $responseCode = null;

	/**
	 * @var array HTTP-Status Code
	 * Custom options holder
	 */
	private $_options = array();

	/**
	 * @var array default curl options
	 * Default curl options
	 */
	private $_defaultOptions = array(
			CURLOPT_USERAGENT => 'Yii-Curl-Agent',
			CURLOPT_TIMEOUT => 30,
			CURLOPT_CONNECTTIMEOUT => 30,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER => false,
	);
	// ############################################### class methods // ##############################################

	/**
	 * Start performing GET-HTTP-Request
	 *
	 * @param string  $url
	 * @param boolean $raw if response body contains JSON and should be decoded
	 *
	 * @return mixed response
	 */
	public function get($url, $raw = true)
	{
		return $this->_httpRequest('GET', $url, $raw);
	}

	/**
	 * Start performing HEAD-HTTP-Request
	 *
	 * @param string $url
	 * @param string $body
	 *
	 * @return mixed response
	 */
	public function head($url)
	{
		return $this->_httpRequest('HEAD', $url);
	}

	/**
	 * Start performing POST-HTTP-Request
	 *
	 * @param string  $url
	 * @param string  $body
	 * @param boolean $raw if response body contains JSON and should be decoded
	 *
	 * @return mixed response
	 */
	public function post($url, $data, $raw = true)
	{
		$this->setOption(CURLOPT_POST, true);
		$this->setOption(
                CURLOPT_POSTFIELDS, 
                is_array($data) ? http_build_query($data) : $data);
		return $this->_httpRequest('POST', $url, $raw);
	}

	/**
	 * Start performing PUT-HTTP-Request
	 *
	 * @param string  $url
	 * @param string  $body
	 * @param boolean $raw if response body contains JSON and should be decoded
	 *
	 * @return mixed response
	 */
	public function put($url, $raw = true)
	{
		return $this->_httpRequest('PUT', $url, $raw);
	}

	/**
	 * Start performing DELETE-HTTP-Request
	 *
	 * @param string  $url
	 * @param string  $body
	 * @param boolean $raw if response body contains JSON and should be decoded
	 *
	 * @return mixed response
	 */
	public function delete($url, $raw = true)
	{
		return $this->_httpRequest('DELETE', $url, $raw);
	}

	/**
	 * Set curl option
	 *
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @return $this
	 */
	public function setOption($key, $value)
	{
		//set value
		$this->_options[$key] = $value;

		//return self
		return $this;
	}

	/**
	 * Unset a single curl option
	 *
	 * @param string $key
	 *
	 * @return $this
	 */
	public function unsetOption($key)
	{
		//reset a single option if its set already
		if(isset($this->_options[$key]))
		{
			unset($this->_options[$key]);
		}

		return $this;
	}

	/**
	 * Unset all curl option, excluding default options.
	 *
	 * @return $this
	 */
	public function unsetOptions()
	{
		//reset all options
		if(isset($this->_options))
		{
			$this->_options = array();
		}

		return $this;
	}

	/**
	 * Total reset of options, responses, etc.
	 *
	 * @return $this
	 */
	public function reset()
	{
		//reset all options
		if(isset($this->_options))
		{
			$this->_options = array();
		}

		//reset response & status code
		$this->response = null;
		$this->responseCode = null;

		return $this;
	}

	/**
	 * Return a single option
	 *
	 * @return mixed // false if option is not set.
	 */
	public function getOption($key)
	{
		//get merged options depends on default and user options
		$mergesOptions = $this->getOptions();

		//return value or false if key is not set.
		return isset($mergesOptions[$key]) ? $mergesOptions[$key] : false;
	}

	/**
	 * Return merged curl options and keep keys!
	 *
	 * @return array
	 */
	public function getOptions()
	{
		return $this->_options+$this->_defaultOptions;
	}

	/**
	 * Performs HTTP request
	 *
	 * @param string  $method
	 * @param string  $url
	 * @param boolean $raw if response body contains JSON and should be decoded -> helper.
	 *
	 * @throws Exception if request failed
	 * @throws HttpException
	 *
	 * @return mixed
	 */
	private function _httpRequest($method, $url, $raw = false)
	{
		//set request type and writer function
		$this->setOption(CURLOPT_CUSTOMREQUEST, strtoupper($method));

		//check if method is head and set no body
		if($method==='HEAD')
		{
			$this->setOption(CURLOPT_NOBODY, true);
			$this->unsetOption(CURLOPT_WRITEFUNCTION);
		}
		
		/**
		 * proceed curl
		 */
		$curl = curl_init($url);
		curl_setopt_array($curl, $this->getOptions());
		$this->response = curl_exec($curl);
		
		if(curl_errno($curl))
		{
			throw new Exception('curl request failed: '.curl_error($curl), curl_errno($curl));
		}

		//retrieve response code
		$this->responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		
		//stop curl
		curl_close($curl);
		
		if ($this->responseCode == 200)
		{
			$this->response = $raw ? $this->response : Json::decode($this->response);
			return $this->response;
		}
		else
		{
			exit($this->response);
		}
	}
}