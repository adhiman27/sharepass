<?php
 
/**
 * Hash class
 */

class Hash
{
  
  private static $_hasher;

  private function __construct() {}  // disallow creating a new object of the class with new Hash()

  private function __clone() {}  // disallow cloning the class


  /**
   * Get a hash of the text
   *
   * @param string $text  The cleartext
   * @return string       The hash
   */
  public static function make($text,$text2)
  {
    return static::_getHasher()->aes128Encrypt($text,$text2);
  }
	
	 public static function decrypt($text,$text2)
  {
    return static::_getHasher()->aes128Decrypt($text,$text2);
  }




  /**
   * Get the singleton password hasher object
   *
   * @return PasswordHash
   */
  private static function _getHasher()
  {
    if (static::$_hasher === NULL) {

      require dirname(dirname(__FILE__)) . '/vendor/PasswordHash.php';

      static::$_hasher = new PasswordHash(8, false);
    }

    return static::$_hasher;
  }

}
