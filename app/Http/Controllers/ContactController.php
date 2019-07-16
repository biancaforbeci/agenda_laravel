<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $contacts = Contact::all();
      return response()->json($contacts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewContacts()
    {
      return view("agenda_eletronica");
    }

    public function viewMessageContact($id)
    {
        return redirect()->route('message-contact', ['name' => $contact->name]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $contact = new Contact();
      $contact->fill($request->all());
      $contact->save();

      return response()->json($contact, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $contact = Contact::find($id);

        if(!$contact) {
            return response()->json([
                'message'   => 'Contato não encontrado !',
            ], 404);
        }

        return response()->json($contact);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $contact = Contact::find($id);

       if(!$contact) {
           return response()->json([
               'message'   => 'Contato não encontrado',
           ], 404);
       }

       return response()->json($contact);
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
      $contact = Contact::find($id);

      if(!$contact) {
          return response()->json([
              'message'   => 'Contato não encontrado !',
          ], 404);
      }

      $contact->fill($request->all());
      $contact->save();

      return response()->json($contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $contact = Contact::find($id);

      if(!$contact) {
          return response()->json([
              'message'   => 'Mensagem não encontrada',
          ], 404);
      }

      $contact->delete();
    }
}
