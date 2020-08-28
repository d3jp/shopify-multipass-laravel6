<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
class ShopifyMultiController extends Controller
{
    //
    private $encryption_key;
    private $signature_key;
    public function __construct($multipass_secret) {
        // Use the Multipass secret to derive two cryptographic keys,
        // one for encryption, one for signing
        $key_material = hash("sha256", $multipass_secret, true);
        $this->encryption_key = substr($key_material, 0, 16);
        $this->signature_key = substr($key_material, 16, 16);
    }
    public function generate_token($customer_data_hash) {
        // Store the current time in ISO8601 format.
        // The token will only be valid for a small timeframe around this timestamp.
        $customer_data_hash["created_at"] = date("c");
        // Serialize the customer data to JSON and encrypt it
        $ciphertext = $this->encrypt(json_encode($customer_data_hash));
        // Create a signature (message authentication code) of the ciphertext
        // and encode everything using URL-safe Base64 (RFC 4648)
        return strtr(base64_encode($ciphertext . $this->sign($ciphertext)), '+/', '-_');
    }
    private function encrypt($plaintext) {
        // Use a random IV
        $iv = openssl_random_pseudo_bytes(16);
        // Use IV as first block of ciphertext
        return $iv . openssl_encrypt($plaintext, "AES-128-CBC", $this->encryption_key, OPENSSL_RAW_DATA, $iv);
    }
    private function sign($data) {
        return hash_hmac("sha256", $data, $this->signature_key, true);
    }
}