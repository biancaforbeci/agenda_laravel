<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Illuminate\Support\Facades\View;
use App\Contact;
use Symfony\Component\HttpFoundation\Session\Session;

class MessageController extends Controller
{
    /**
     * retorna todas as mensagens independe de contato
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $messages = Message::all();
      return response()->json($messages);
    }

    /**
     * show view enviar mensagem.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewNewMessage()
    {
        return view("add_message");
    }

    //encontrar mensagem de um contato.
    public function messagesContact($array)
    {
      $session = new Session();
      $contact = $session->get('contact');

       if(empty($contact)){
         return redirect()->back();
       }else{
         $session = new Session();
         $session->set('contact', $contact);
       }

       $messages_contact = Message::where('contact_id', '=', $contact->id)->get();
       $json = json_encode($messages_contact);
       $jsonContact = json_encode($contact);
       return View::make('contact_message', compact('messages_contact', 'json'), compact('contact', 'jsonContact'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      error_log($request);
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
              'message'   => 'Mensagem não encontrada !',
          ], 404);
      }
      error_log($request->description);
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
