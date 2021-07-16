<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;

class siteController extends Controller
{
    const API_BASE = 'https://blog-api.stmik-amikbandung.ac.id/api/v2/blog/_table/';
    const API_KEY = 'ef9187e17dce5e8a5da6a5d16ba760b75cadd53d19601a16713e5b7c4f683e1b';

    private $apiClient;

    public function __construct(){
        $this->apiClient = new Client([
            'base_uri'=>self::API_BASE,
            'headers'=>[
                'X-DreamFactory-API-Key' => self::API_KEY
            ]
        ]);
    }

    public function index()
    {   
        $key = "articles?related=*&sort=id desc";
        $data = Cache::get($key, function() use ($key){
           try{
                $reqData = $this->apiClient->get($key);
                $resource= json_decode($reqData->getBody())->resource;
                Cache::add('index', $resource);
                return $resource;
           }catch(ReuestException $e){
               return [];
           }
       });
       return view('index', ['data'  =>$data]);
    }

    public function getArticles($id){
        // get artikel
        $key = "articles/{$id}";
        $data = Cache::get($key, function() use ($key){
            try{
                $reqData=$this->apiClient->get($key);
                $resource=json_decode($reqData->getBody());
                Cache::add($key, $resource);
                return $resource;
            }catch(Exception $e){
                abort(404);
            }
        });

        
        return view('viewArticle', ['data' => $data]);
    }

    public function newArticles(Request $request)
    {
        if($request->isMethod('post')){
            $title = $request->input('frm-title');
            $content = $request->input('frm-content');
            $authordata = $request->input('author');
            $dataModel =[
                'resource' => []
            ];

            $dataModel['resource'][]= [
                'author'=>$authordata,
                'title'=>$title,
                'content'=>$content
            ];

            try{
                $reqData = $this->apiClient->post('articles',[
                    'json' => $dataModel
                ]);
                $apiResponse = json_decode($reqData->getBody())->resource;
                $newId = $apiResponse[0]->id;

                Cache::forget('index');

                return redirect("/articles/{$newId}");
            }catch(Exception $e){
                abort(501);
            }
        }
        // get author
        $key = "authors/";
        $data2 = Cache::get($key, function() use ($key){
            try{
                $reqData=$this->apiClient->get($key);
                $resource=json_decode($reqData->getBody());
                Cache::add($key, $resource);
                return $resource;
            }catch(Exception $e){
                abort(404);
            }
        });
        return view('newArticle',['data'=>$data2->resource]);
    }

    public function commentAdd(Request $request,$id)
    {
        if($request->isMethod('post')){
            $author = $request->input('author');
            $comment = $request->input('comment');
            $article = $request->input('article');

            // dd($article);

            $dataModel =[
                'resource' => []
            ];

            $dataModel['resource'][]= [
                'article'=>$article,
                'author'=>$author,
                'content'=>$comment,
                
            ];

            try{
                $reqData = $this->apiClient->post('comments',[
                    'json' => $dataModel
                ]);
                $apiResponse = json_decode($reqData->getBody())->resource;
                $newId = $apiResponse[0]->id;

                Cache::forget('index');

                return redirect("/");
            }catch(Exception $e){
                abort(501);
            }
        }

        // get author
        $key = "authors/";
        $author_Data = Cache::get($key, function() use ($key){
            try{
                $reqData=$this->apiClient->get($key);
                $resource=json_decode($reqData->getBody());
                Cache::add($key, $resource);
                return $resource;
            }catch(Exception $e){
                abort(404);
            }
        });
        return view('addComment',["data"=>$id,"author"=>$author_Data->resource]);
    }

    public function editArtikel(Request $request,$id){
        if($request->isMethod('post')){
            $title = $request->input('frm-title');
            $content = $request->input('frm-content');
            $authordata = $request->input('author');
            $dataModel =[
                'resource' => []
            ];

            $dataModel['resource'][]= [
                'author'=>$authordata,
                'title'=>$title,
                'content'=>$content
            ];

            try{
                $reqData = $this->apiClient->PUT('articles?filter=id='.$id,[
                    'json' => $dataModel
                ]);
                $apiResponse = json_decode($reqData->getBody())->resource;
                $newId = $apiResponse[0]->id;

                Cache::forget('index');

                return redirect("/articles/{$newId}");
            }catch(Exception $e){
                abort(501);
            }
        }
        // get author -- selector
        $key = "authors/";
        $data2 = Cache::get($key, function() use ($key){
            try{
                $reqData=$this->apiClient->get($key);
                $resource=json_decode($reqData->getBody());
                Cache::add($key, $resource);
                return $resource;
            }catch(Exception $e){
                abort(404);
            }
        });

        // get data before edit
        $beditkey = "articles?filter=id={$id}&related=*";
        $databedit = Cache::get($beditkey, function() use ($beditkey){
            try{
                $reqData=$this->apiClient->get($beditkey);
                $resource=json_decode($reqData->getBody());
                Cache::add($beditkey, $resource);
                return $resource;
            }catch(Exception $e){
                abort(404);
            }
        });
        return view('editArticle',["author"=>$data2->resource,'bedit'=>$databedit->resource[0]]);
    }

    public function listAuthor()
    {
        $data = Cache::get('author/list', function(){
            try{
                 $reqData = $this->apiClient->get('authors');
                 $resource= json_decode($reqData->getBody())->resource;
                 Cache::add('author/list', $resource);
                 return $resource;
            }catch(ReuestException $e){
                return [];
            }
        });

        return view('listAuthor', ['data'  =>$data ]
                );
    }   

    public function deleteArtikel($id,$comment){
        if ($comment > 0){
        $firstkey = "comments?filter=article={$id}";
        $data = Cache::get($firstkey, function() use ($firstkey){
            try{
                 $reqData = $this->apiClient->delete($firstkey);
                 return (200);
            }catch(ReuestException $e){
             return (501);
            }
        });
        }

        $key = "articles/{$id}";
        $data = Cache::get($key, function() use ($key){
           try{
                $reqData = $this->apiClient->delete($key);
                $resource= json_decode($reqData->getBody());
                return (200);
           }catch(ReuestException $e){
            return abort(501);
           }
       });
    //    dd($data);
       return $data;
    }
}
