<?php

class PasswordHash{
	

// Encrypting
function aes128Encrypt($key, $data) {
  if(16 !== strlen($key)) $key = hash('MD5', $key, true);
  $padding = 16 - (strlen($data) % 16);
  $data .= str_repeat(chr($padding), $padding);
  return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, str_repeat("\0", 16)));
}

// Decrypting 
function aes128Decrypt($key, $data) {
  $data = base64_decode($data);
  if(16 !== strlen($key)) $key = hash('MD5', $key, true);
  $data = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, str_repeat("\0", 16));
  $padding = ord($data[strlen($data) - 1]); 
  return substr($data, 0, -$padding); 
}
	
}


?>