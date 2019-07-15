<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view("add_message");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $message = new Message();
      $message->fill($request->all());
      $message->save();

      return response()->json($message, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $message = Message::find($id);

        if(!$message) {
            return response()->json([
                'message'   => 'Mensagem não encontrada !',
            ], 404);
        }

        return response()->json($message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $message = Message::find($id);

       if(!$message) {
           return response()->json([
               'message'   => 'Mensagem não encontrada',
           ], 404);
       }

       return response()->json($message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $message = Message::find($id);

      if(!$message) {
          return response()->json([
              'message'   => 'Contato não encontrado !',
          ], 404);
      }

      $message->fill($request->all());
      $message->save();

      return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $message = Message::find($id);

      if(!$message) {
          return response()->json([
              'message'   => 'Mensagem não encontrada',
          ], 404);
      }

      $message->delete();
    }
}
