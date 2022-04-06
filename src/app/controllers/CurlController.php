<?php
require '../vendor/autoload.php';

use Phalcon\Mvc\Controller;
use GuzzleHttp\Client;

class CurlController extends Controller
{
    public function indexAction()
    {
    }
    public function booksAction()
    {
        $host = 'https://openlibrary.org/search.json?q=';
        $url = $this->request->get('search');
        $len = strlen($url);
        for ($i = 0; $i < $len; $i++) {
            if ($url[$i] == ' ') {
                $url[$i] = '+';
            }
        }
        $path = '&mode=ebooks&has_fulltext=true';
        $url2 = $host.$url.$path;
         
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $url2,
        ]);
          
        
        $response = $client->request('GET');
          
          
        $body = $response->getBody();
        $arr_body = json_decode($body);
        $this->view->books = $arr_body;
    }
    public function fullpageAction()
    {
        $full = $this->request->getPost();
        $this->view->look = $full;
    }
    public function googleAction()
    {
        $host = 'https://www.google.co.in/books/edition/';
        if (isset($_POST['google_id'])) {
            $slug = $this->request->get('title');
            $edition_id = $this->request->get('google_id');
            $len = strlen($slug);
            for ($i = 0; $i < $len; $i++) {
                if ($slug[$i] == ' ') {
                    $slug[$i] = '+';
                }
            }
            $path = '?hl=en';
            $url2 = $host . $slug . '/' . $edition_id . '/' . $path;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url2);
            curl_exec($ch);
        }
    }
}
