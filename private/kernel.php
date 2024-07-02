<?php
class Website {
    private $database;
    public function getUser(){
        if(!$this->database){
            $this->database = new Database;
        }
        if(isset($_COOKIE['session'])) {
            $session = $_COOKIE['session'];
    
            // Check the session is valid
            $stmt = $this->database->exe("SELECT * FROM `users` WHERE `session` = ?", [$session]);
    
            if ($stmt) {
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                if($row){
                    return $row;
                } else{
                    return false;
                }
            }
        } else {
            return false;
        }
    }
    public function getWholeSlug(){
        return '/'.trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }
    public function loadPage($page){
        if(file_exists(dirname(__FILE__)."/pages$page/index.php")){
            include(dirname(__FILE__)."/pages/$page/index.php");
        } else{
            $this->give_404();
        }
    }
    public function give_404(){
        http_response_code(404);
        if(file_exists(dirname(__FILE__)."/pages/404/index.php")){
            include(dirname(__FILE__)."/pages/404/index.php");
        } else{
            echo "An error has occoured. 404 page not found: ".$this->getWholeSlug();
        }
    }
    public function giveApiError($error){
        header("Content-Type: application/json; charset=UTF-8");

        echo json_encode([
            'status' => 'error',
            'error' => $error
        ]);
        exit();
    }
    public function giveApiResponse($reponse){
        header("Content-Type: application/json; charset=UTF-8");

        echo json_encode($reponse);
        exit();
    }
    public function loginRedirect($type){
        if(!$this->getUser() && $type == 1){
            header('location: /login');
            exit();
        }
        if($this->getUser() && $type == 2){
            header('location: /dashboard');
            exit();
        }
    }
}
class Database {
    private $env;
    private $conn;

    public function __construct() {
        $this->env = $this->loadEnv(__DIR__ . '/.env');

        $this->conn = new mysqli($this->env->DB_HOST, $this->env->DB_USERNAME, $this->env->DB_PASSWORD, $this->env->DB_DATABASE);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    public function exe($sql, $params) {
        // Ensure $this->conn is a valid mysqli instance
        if (!$this->conn instanceof mysqli) {
            echo("Database connection is not a valid mysqli instance.");
            return false;
        }
    
        try {
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                echo("Failed to prepare the statement: " . $this->conn->error);
                return false;
            }
    
            // Bind parameters
            if ($params) {
                // Create a string with the types of the parameters
                $types = str_repeat('s', count($params)); // assuming all parameters are strings for simplicity
                $stmt->bind_param($types, ...$params);
            }
    
            // Execute the statement
            if ($stmt->execute()) {
                return $stmt;
            } else {
                echo("Failed to execute the statement: " . $stmt->error);
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            // Log detailed error message
            echo("Error executing prepared statement: " . $e->getMessage());
            return false;
        }
    }

    private function loadEnv($path) {
        if (!file_exists($path)) {
            throw new Exception("The .env file does not exist.");
        }

        $env = [];
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parse key=value pairs
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            // Remove quotes from value if present
            $value = trim($value, "'\"");

            // Store the key-value pair in the array
            $env[$key] = $value;
        }

        // Convert the array to an object
        return (object) $env;
    }
}
class AccountTools{
    public function encryptPassword($password, $hash){
        $secret_key = "ydygfuireytdfviute65yf5et".$hash;
        $cipher = "aes-256-cbc";
        $options = 0;
        $iv = "74hf8rh3ng06hdgr";
        return (openssl_encrypt($password, $cipher, $secret_key, $options, $iv));
    }
    public function validateEmail($email) {
        $pattern = '/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,4}$/';
        return preg_match($pattern, $email) === 1;
    }
    public function validatePassword($password) {
        $pattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/';
        return preg_match($pattern, $password) === 1;
    }
    public function generateRandom($len){
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $len);
    }
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Mail{

    public function sendMail() {
        require dirname(__FILE__).'/../../vendor/autoload.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp-relay.brevo.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ericrosa914@gmail.com';
                $mail->Password = '';
                $mail->Port = 587;
                $mail->SMTPSecure = "tls";

                // Recipients
                $mail->setFrom('thecurve@odysseynetw.co.uk', 'Mailer');
                $mail->addAddress('d4ws70@gmail.com', 'Recipient Name');

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'THE CURVE : NOTIFICATION SYSTEM';
                $mail->Body    = file_get_contents("./email.html");
                $mail->send();
                echo 'EMAIL SENT.';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
}
