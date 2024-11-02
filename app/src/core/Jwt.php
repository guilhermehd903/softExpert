<?php
namespace Softexpert\Mercado\core;

class Jwt{

	private $secret;

	public function __construct() {
		$this->secret = $_ENV['JWT_SECRET'];
	}

	public function create($data) {

		$header = json_encode(array("typ"=>"JWT", "alg"=>"HS256"));

		$payload = json_encode($data);

		$hbase = base64url_encode($header);
		$pbase = base64url_encode($payload);

		$signature = hash_hmac("sha256", $hbase.".".$pbase, $this->secret, true);
		$bsig = base64url_encode($signature);

		$jwt = $hbase.".".$pbase.".".$bsig;

		return $jwt;
	}

	public function validate($token) {
		$array = array();

		$jwt_split = explode('.', $token);

		if(count($jwt_split) == 3) {
			$signature = hash_hmac("sha256", $jwt_split[0].".".$jwt_split[1], $this->secret, true);
			$bsig = base64url_encode($signature);

			if($bsig == $jwt_split[2]) {

				$array = json_decode(base64url_decode($jwt_split[1]));
				return $array;

			} else {
				return false;
			}

		} else {
			return false;
		}

	}

}