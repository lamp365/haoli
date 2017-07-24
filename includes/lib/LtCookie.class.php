<?php
// cookie 类，用于实现cookie的方法
class LtCookie
{
	private $secretKey;
    // 初始化cookie 的安全key;
	public function ___construct(){ 
		$this->secretKey = "comhinrcwwwcookie" ;
	}
	/**
	 * 解码cookie值
	 * 
	 * @param string $encryptedText 
	 * @return string 
	 */
	protected function decrypt($encryptedText)
	{
		return $encryptedText;
		$key = $this->secretKey;
		$cryptText = base64_decode($encryptedText);
		$ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
		$decryptText = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $cryptText, MCRYPT_MODE_ECB, $iv);
		return trim($decryptText);
	}
	
	/**
	 * 编码cookie值
	 * 
	 * @param string $plainText 
	 * @return string 
	 */
	protected function encrypt($plainText)
	{
		return $plainText;
		$key = $this->secretKey;
		$ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
		$encryptText = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $plainText, MCRYPT_MODE_ECB, $iv);
		return trim(base64_encode($encryptText));
	}
	/**
	 * 根据key来删除cookie数据
	 * 
	 * @param array $args 
	 * @return boolean 
	 */
	public function delCookie($name, $path = '/', $domain = null)
	{
		if (isset($_COOKIE[$name]))
		{
			if (is_array($_COOKIE[$name]))
			{
				foreach($_COOKIE[$name] as $k => $v)
				{
					setcookie($name . '[' . $k . ']', '', time() - 86400, $path, $domain);
				}
			}
			else
			{
				setcookie($name, '', time() - 86400, $path, $domain);
			}
		}
	}
	/**
	 * 根据key来获取cookie数据
	 * 
	 * @param string $name 
	 * @return mixed 
	 */
	public function getCookie($name)
	{
		$ret = null;
		if (isset($_COOKIE[$name]))
		{
			if (is_array($_COOKIE[$name]))
			{
				$ret = array();
				foreach($_COOKIE[$name] as $k => $v)
				{
					$v = $this->decrypt($v);
					$ret[$k] = $v;
				}
			}
			else
			{
				$ret = $this->decrypt($_COOKIE[$name]);
			}
		}
		return $ret;
	}

	/**
	 * 设置cookie数据
	 * 
	 * @param array $args 
	 * @return boolean 
	 */
	public function setCookie($name, $value = '', $expire = null, $path = '/', $domain = null, $secure = 0)
	{
		if (is_array($value))
		{
			foreach($value as $k => $v)
			{
				$v = $this->encrypt($v);
				setcookie($name . '[' . $k . ']', $v, $expire, $path, $domain, $secure);
			}
		}
		else
		{
			$value = $this->encrypt($value);
			setcookie($name, $value, $expire, $path, $domain, $secure);
		}
	}
}