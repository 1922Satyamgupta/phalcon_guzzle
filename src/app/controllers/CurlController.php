<?php

use Phalcon\Mvc\Controller;
class CurlController extends Controller
{
    public function indexAction()
    {
        
    }
    public function booksAction() {
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

        $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url2);
      

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
   
         $a =json_decode($response); 
     
         $this->view->books = $a;
    }
    public function fullpageAction() {
        $full = $this->request->getPost();
        $this->view->look = $full;
    }
    public function googleAction() {
        $host = 'https://www.google.co.in/books/edition/';
        if(isset($_POST['google_id'])){
        $slug = $this->request->get('title');
        $edition_id = $this->request->get('google_id');
        $len = strlen($slug);
        for ($i = 0; $i < $len; $i++) {
            if ($slug[$i] == ' ') {
                $slug[$i] = '+';
            }
        }
        $path = '?hl=en';
        $url2 = $host.$slug.'/'.$edition_id.'/'.$path;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url2);
        curl_exec($ch);
    }
}
}