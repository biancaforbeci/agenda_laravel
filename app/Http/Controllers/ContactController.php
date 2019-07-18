<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use DB;
use Symfony\Component\HttpFoundation\Session\Session;

class ContactController extends Controller
{
    /**
     * Todos os contatos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $contacts = DB::table('contacts')
       ->select('id', 'name', 'lastname','email','phone')
       ->orderBy('name', 'asc')
       ->get();
      return response()->json($contacts);
    }

    /**
    * pegando lista por nomes
    *
    * @return \Illuminate\Http\Response
    */
    public function takingNames(Request $request)
    {
        // procurando por nome
      $contacts = Contact::select('id', 'name')
                  ->where('name', 'LIKE', "%".$request->input('search')."%")
                  // ->select('id', 'name')
                  ->take(4)
                  ->get();

        return response()->json($contacts);
    }

    /**
     * Show view agenda_eletronica
     *
     * @return \Illuminate\Http\Response
     */
    public function viewContacts()
    {
      return view("agenda_eletronica");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewMessageContact($id)
    {
        $contact = Contact::find($id);

        if(!$contact) {
            return redirect()->back();
        }

        $session = new Session();
        $session->set('contact', $contact);

        return redirect()->route('return-viewNewMessage', ['name' => $contact->name]);
    }

    /**
     * saving contact
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
     * find contact
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
     * show contact to edit
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
     * update contact
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
     * delete contact
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
