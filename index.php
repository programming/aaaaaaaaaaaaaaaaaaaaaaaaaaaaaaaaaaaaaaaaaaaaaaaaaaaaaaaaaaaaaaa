<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA</title>
</head>
<body>
<h1>AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA</h1>
<p>Are your URLs too short? Lengthen your URLs conveniently and share your links without ambiguity (<em>"All As."</em>).</p>
<p><form action="/" method="get"><input type="url" name="url" placeholder="Enter your URL..."> <input value="Lengthen" type="submit"></form></p>

<?php

$Aa = new Aa();
$Aa->run();

class Aa {

    public function __construct() {
        $this->hostname = 'http://aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.com';
        $this->connection = nnew PDO('mysql:dbname=MYSQL_DATABASE_NAME;host=localhost', 'MYSQL_DATABASE_USER', 'MYSQL_DATABASE_USER_PASSWORD');
		$this->chars = 'aA';
    }

    public function encode($n) {
        return self::num_to_alpha($n, $this->chars);
    }

    public function decode($s) {
        return self::alpha_to_num($s, $this->chars);
    }

    public static function num_to_alpha($n, $s) {
        $b = strlen($s);
        $m = $n % $b;

        if ($n - $m == 0) return substr($s, $n, 1);

        $a = '';

        while ($m > 0 || $n > 0) {
            $a = substr($s, $m, 1).$a;
            $n = ($n - $m) / $b;
            $m = $n % $b;
        }

        return $a;
    }

    public static function alpha_to_num($a, $s) {
        $b = strlen($s);
        $l = strlen($a);

        for ($n = 0, $i = 0; $i < $l; $i++) {
            $n += strpos($s, substr($a, $i, 1)) * pow($b, $l - $i - 1);
        }

        return $n;
    }

    public function fetch($id) {
        $statement = $this->connection->prepare(
            'SELECT * FROM urls WHERE id = ?'
        );
        $statement->execute(array($id));

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function find($url) {
        $statement = $this->connection->prepare(
            'SELECT * FROM urls WHERE url = ?'
        );
        $statement->execute(array($url));

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function store($url) {
        $datetime = date('Y-m-d H:i:s');

        $statement = $this->connection->prepare(
            'INSERT INTO urls (url, created) VALUES (?,?)'
        );
        $statement->execute(array($url, $datetime));

        return $this->connection->lastInsertId();
    }

    public function update($id) {
        $datetime = date('Y-m-d H:i:s');

        $statement = $this->connection->prepare(
            'UPDATE urls SET hits = hits + 1, accessed = ? WHERE id = ?'
        );
        $statement->execute(array($datetime, $id));
    }

    public function redirect($url) {
        header("Location: $url", true, 301);
        exit();
    }

    public function run() {
        $q = str_replace('/', '', $_GET['q']);

        $url = '';
        if (isset($_GET['url'])) {
          $url = urldecode($_GET['url']);
        }

        if (!empty($url)) {

            if (preg_match('/^http[s]?\:\/\/[\w]+/', $url)) {
                $result = $this->find($url);

                if (empty($result)) {
                    $id = $this->store($url);
                    $url = $this->hostname.'/'.$this->encode($id);
                }
                else {
                    $url = $this->hostname.'/'.$this->encode($result['id']);
                }

				echo '<a rel="nofollow noopener noreferrer" target="_blank" href="'.$url.'">'.$url.'</a>';
            }
        }

        else {
            if ($q) {
                if (preg_match('/^([a-zA-Z0-9]+)$/', $q, $matches)) {
                    $id = self::decode($matches[1]);
                    $result = $this->fetch($id);
    
                    if (!empty($result)) {
                        $this->update($id);
                        $this->redirect($result['url']);
                    }
                }
            }
        }
    }
}

echo '</body></html>';
?>
