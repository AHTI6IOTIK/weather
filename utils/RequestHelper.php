<?php


namespace utils;


class RequestHelper
{

	protected $scheme = 'http';
	protected $query_method = 'GET';
	protected $host;
	protected $path;
	protected $get_params;
	protected $post_params;
	protected $headers;
	protected $body;

	public function send() {

		$response = false;
		$url_path = sprintf('%s://%s/%s', $this->scheme, $this->host, $this->path);

		if (!empty($this->get_params) && is_array($this->get_params)) {
			$url_path .= '?' .$this->getPrepareGetParams();
		}

		if ($this->isLoadCurl()) {

			$response = $this->sendQueryCurl($url_path);
		} else {

			$response = $this->sendQueryStream($url_path);
		}
		return $response;
	}

	protected function sendQueryStream($url) {

		$response = false;
		$options = [
			'method' => $this->query_method,
			'header' => $this->getPrepareHeaders(),
			'content' => $this->getBodyRequest()
		];

		$context = stream_context_create(['http' => $options]);
		$response = file_get_contents($url, false, $context);
		return $response;
	}

	protected function sendQueryCurl($url) {


		$response = false;
		$cn = curl_init($url);
		curl_setopt($cn, CURLOPT_CUSTOMREQUEST, $this->getQueryMethod());

		if (!empty($this->headers)) {

			curl_setopt($cn, CURLOPT_HTTPHEADER, $this->headers);
		}

		if (!empty($this->getBodyRequest())) {

			curl_setopt($cn, CURLOPT_POSTFIELDS, $this->getBodyRequest());
		}

		curl_setopt($cn, CURLOPT_RETURNTRANSFER, 1);

		if ($exec = curl_exec($cn)) {
			$response = $exec;
		}
		curl_close($cn);
		unset($cn, $exec);

		return $response;
	}

	protected function getBodyRequest() {

		$body = $this->getPreparePostParams() . $this->getBody();
		return $body;
	}

	protected function getPrepareGetParams() {

		return http_build_query($this->get_params);
	}

	protected function getPreparePostParams() {

		if (empty($this->post_params)) {
			return false;
		}

		$post = http_build_query($this->post_params);
		$post = urlencode($post);
		if (strlen($post) > 0) {
			$post .= "\r\n";
		}
		return $post;
	}

	protected function getPrepareHeaders() {

		return implode("\r\n", $this->headers);
	}


	protected function isLoadCurl(): bool {

		return (boolean)extension_loaded('curl');
	}

	/**
	 * @param $scheme
	 * @return $this
	 */
	public function setScheme($scheme) {

		$this->scheme = $scheme;
		return $this;
	}

	/**
	 * @param $host
	 * @return $this
	 */
	public function setHost($host) {

		$this->host = $host;
		return $this;
	}

	/**
	 * @param $path
	 * @return $this
	 */
	public function setPath($path) {

		$this->path = $path;
		return $this;
	}

	/**
	 * @param $get_params
	 * @return $this
	 */
	public function setGetParams($get_params) {

		$this->get_params = $get_params;
		return $this;
	}

	/**
	 * @param $param_name
	 * @param $param_value
	 * @return $this
	 */
	public function addGetParam($param_name, $param_value) {

		$this->get_params[$param_name] = $param_value;
		return $this;
	}

	/**
	 * @param $post_params
	 * @return $this
	 */
	public function setPostParams($post_params) {

		$this->post_params = $post_params;
		return $this;
	}

	/**
	 * @param $query_method
	 * @return $this
	 */
	public function setQueryMethod($query_method) {

		$this->query_method = $query_method;
		return $this;
	}

	/**
	 * @param $body
	 * @return $this
	 */
	public function setBody($body) {

		$this->body = $body;
		return $this;
	}

	/**
	 * @param $headers
	 * @return $this
	 */
	public function setHeaders(array $headers) {

		$this->headers = $headers;
		return $this;
	}

	/**
	 * @param $headers
	 * @return $this
	 */
	public function addHeader($headers) {

		$this->headers[] = $headers;
		return $this;
	}

	/**
	 * @param $scheme
	 * @return mixed
	 */
	public function getScheme($scheme) {

		return $scheme;
	}

	/**
	 * @param $host
	 * @return mixed
	 */
	public function getHost($host) {

		return $host;
	}

	/**
	 * @param $path
	 * @return mixed
	 */
	public function getPath($path) {

		return $path;
	}

	/**
	 * @return mixed
	 */
	public function getGetParams() {

		return $this->get_params;
	}

	/**
	 * @return mixed
	 */
	public function getPostParams() {

		return $this->post_params;
	}

	/**
	 * @return string
	 */
	public function getQueryMethod() {

		return $this->query_method;
	}

	/**
	 * @param $body
	 * @return mixed
	 */
	public function getBody() {

		$body = $this->body;

		if (strlen($body) > 0) {
			$body .= "\r\n";
		} else {

			$body = false;
		}

		return $body;
	}

	/**
	 * @return mixed
	 */
	public function getHeaders() {

		return $this->headers;
	}
}