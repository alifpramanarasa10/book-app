<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchController extends Controller
{
    public function getData()
    {   
        Log::info('starting get data from jsonplaceholder');
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');
        Log::critical('success get data');
        Log::emergency('success get data');
        Log::alert('success get data');
        return $response->json();
    }

    public function showData($id)
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/posts/'.$id);

        return $response->json();
    }

    public function createData(Request $request)
    {
        $response = Http::withHeaders([
            'Content-type' => 'application/json; charset=UTF-8'
        ])->post('https://jsonplaceholder.typicode.com/posts', [
            'title'  => $request->title,
            'body'   => $request->body,
            'userId' => $request->user_id
        ]);

        return $response->json();
    }

    public function UpdateData(Request $request, $id)
    {
        $response = Http::withHeaders([
            'Content-type' => 'application/json; charset=UTF-8'
        ])->put('https://jsonplaceholder.typicode.com/posts/'.$id, [
            'id'     => $id,
            'title'  => $request->title,
            'body'   => $request->body,
            'userId' => $request->user_id
        ]);

        return $response->json();
    }

    public function PatchData(Request $request, $id)
    {
        $response = Http::withHeaders([
            'Content-type' => 'application/json; charset=UTF-8'
        ])->patch('https://jsonplaceholder.typicode.com/posts/'.$id, [
            'id'     => $id,
            'title'  => $request->title,
            'body'   => $request->body,
            'userId' => $request->user_id
        ]);

        return $response->json();
    }

    public function deleteData($id)
    {
        $response = Http::delete('https://jsonplaceholder.typicode.com/posts/'.$id);

        return $response->json();
    }
    public function filteringData($id)
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/posts?userId='.$id);        
        
        return $response->json();
    }
    public function nestedData($id)
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/posts/'.$id.'/comments');        
        
        return $response->json();
    }
    public function userTodos($id)
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/user/'.$id.'/todos');        
        
        return $response->json();
    }
}