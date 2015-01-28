<?php
/**
 * Misc. Functions
 *
 * These functions were pulled from various open source software packages.
 *
 * @author	Svend Sorensen
 * @version	$Id: functions.php 49 2006-04-21 00:16:50Z svends $
 */

/*
 * Package: phpldapadmin
 * License: GPL
 *
 * I had to comment out debugging and error reporting code.
 */

/**
 * Hashes a password and returns the hash based on the specified enc_type.
 *
 * @param string $password_clear The password to hash in clear text.
 * @param string $enc_type Standard LDAP encryption type which must be one of
 *        crypt, ext_des, md5crypt, blowfish, md5, sha, smd5, ssha, or clear.
 * @return string The hashed password.
 */
function password_hash( $password_clear, $enc_type ) {
//	debug_log(sprintf('password_hash(): Entered with (%s,%s)',$password_clear,$enc_type),2);

//	global $lang;

	$enc_type = strtolower( $enc_type );

	switch( $enc_type ) {
		case 'crypt':
			$new_value = '{CRYPT}' . crypt( $password_clear, random_salt(2) );
			break;

		case 'ext_des':
			// extended des crypt. see OpenBSD crypt man page.
			if ( ! defined( 'CRYPT_EXT_DES' ) || CRYPT_EXT_DES == 0 )
//				pla_error( $lang['install_not_support_ext_des'] );

			$new_value = '{CRYPT}' . crypt( $password_clear, '_' . random_salt(8) );
			break;

		case 'md5crypt':
			if( ! defined( 'CRYPT_MD5' ) || CRYPT_MD5 == 0 )
//				pla_error( $lang['install_not_support_md5crypt'] );

			$new_value = '{CRYPT}' . crypt( $password_clear , '$1$' . random_salt(9) );
			break;

		case 'blowfish':
			if( ! defined( 'CRYPT_BLOWFISH' ) || CRYPT_BLOWFISH == 0 )
//				pla_error( $lang['install_not_support_blowfish'] );

			// hardcoded to second blowfish version and set number of rounds
			$new_value = '{CRYPT}' . crypt( $password_clear , '$2a$12$' . random_salt(13) );
			break;

		case 'md5':
			$new_value = '{MD5}' . base64_encode( pack( 'H*' , md5( $password_clear) ) );
			break;

		case 'sha':
			if( function_exists('sha1') ) {
				// use php 4.3.0+ sha1 function, if it is available.
				$new_value = '{SHA}' . base64_encode( pack( 'H*' , sha1( $password_clear) ) );

			} elseif( function_exists( 'mhash' ) ) {
				$new_value = '{SHA}' . base64_encode( mhash( MHASH_SHA1, $password_clear) );

			} else {
//				pla_error( $lang['install_no_mash'] );
			}
			break;

		case 'ssha':
			if( function_exists( 'mhash' ) && function_exists( 'mhash_keygen_s2k' ) ) {
				mt_srand( (double) microtime() * 1000000 );
				$salt = mhash_keygen_s2k( MHASH_SHA1, $password_clear, substr( pack( "h*", md5( mt_rand() ) ), 0, 8 ), 4 );
				$new_value = "{SSHA}".base64_encode( mhash( MHASH_SHA1, $password_clear.$salt ).$salt );

			} else {
//				pla_error( $lang['install_no_mash'] );
			}
			break;

		case 'smd5':
			if( function_exists( 'mhash' ) && function_exists( 'mhash_keygen_s2k' ) ) {
				mt_srand( (double) microtime() * 1000000 );
				$salt = mhash_keygen_s2k( MHASH_MD5, $password_clear, substr( pack( "h*", md5( mt_rand() ) ), 0, 8 ), 4 );
				$new_value = "{SMD5}".base64_encode( mhash( MHASH_MD5, $password_clear.$salt ).$salt );

			} else {
//				pla_error( $lang['install_no_mash'] );
			}
			break;

		case 'clear':
		default:
			$new_value = $password_clear;
	}

	return $new_value;
}

/*
 * Package: kolab
 * License: GPL
 */

  function escape( $str ) {
    /*
      From RFC-2254:

      If a value should contain any of the following characters

      Character       ASCII value
      ---------------------------
      *               0x2a
      (               0x28
      )               0x29
      \               0x5c
      NUL             0x00

     the character must be encoded as the backslash '\' character (ASCII
     0x5c) followed by the two hexadecimal digits representing the ASCII
     value of the encoded character. The case of the two hexadecimal
     digits is not significant.
     */
    $str = str_replace( '\\', '\\5c', $str );
    $str = str_replace( '*',  '\\2a', $str );
    $str = str_replace( '(',  '\\28', $str );
    $str = str_replace( ')',  '\\29', $str );
    $str = str_replace( '\0', '\\00', $str );
    return $str;
  }

  function dn_escape( $str ) {
	/*
	 DN component escaping as described in RFC-2253
	 */
	$str = str_replace( '\\', '\\\\', $str );
	$str = str_replace( ',', '\\,', $str );
	$str = str_replace( '+', '\\,', $str );
	$str = str_replace( '<', '\\<', $str );
	$str = str_replace( '>', '\\>', $str );
	$str = str_replace( ';', '\\;', $str );
	if( $str[0] == '#' ) $str = '\\'.$str;
	// PENDING(steffen): Escape leading/trailing spaces
	return $str;
  }
?>
