<?php 

 public function getUserMedia($id = 'self', $limit = 0) {
    return $this->_makeCall('users/' . $id . '/media/recent', true, array('count' => $limit));
  }



    $cookie_name = $this->package
    $cookie_value = $this->package
    $_COOKIE[$cookie_name] = $cookie_value;
    if (!headers_sent()) {
      $expire = time() + 31556926;
      setcookie($cookie_name, $cookie_value, $expire);
    } else {
      // @codeCoverageIgnoreStart
      self::errorLog(
        'Shared session ID cookie could not be set! You must ensure you '.
        'create the Facebook instance before headers have been sent. This '.
        'will cause authentication issues after the first request.'
      );

protected function _makeCall($function, $auth = false, $params = null, $method = 'GET') {
    if (false === $auth) {
      // if the call doesn't requires authentication
      $authMethod = '?client_id=' . $this->getApiKey();
    } else {
      // if the call needs an authenticated user
      if (true === isset($this->_accesstoken)) {
        $authMethod = '?access_token=' . $this->getAccessToken();
      } else {
        throw new Exception("Error: _makeCall() | $function - This method requires an authenticated users access token.");
      }
    }
    
    if (isset($params) && is_array($params)) {
      $paramString = '&' . http_build_query($params);
    } else {
      $paramString = null;
    }
    
    $apiCall = self::API_URL . $function . $authMethod . (('GET' === $method) ? $paramString : null);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiCall);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    if ('POST' === $method) {
      curl_setopt($ch, CURLOPT_POST, count($params));
      curl_setopt($ch, CURLOPT_POSTFIELDS, ltrim($paramString, '&'));
    } else if ('DELETE' === $method) {
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    }
    
    $jsonData = curl_exec($ch);
    if (false === $jsonData) {
      throw new Exception("Error: _makeCall() - cURL error: " . curl_error($ch));
    }
    curl_close($ch);
    
    return json_decode($jsonData);
  }
