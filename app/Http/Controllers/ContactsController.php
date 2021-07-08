<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactsController extends Controller
{
    private $array = ['error' => '', 'result' => []];

    public function all(){
        $contacts = Contact::all();

        foreach($contacts as $contact){
            $this->array['result'][]= [
                'id' => $contact->id,
                'name' => $contact->name,
                'number' => $contact->number
            ];
        }

        return $this->array;
    }

    public function one($id){
        $contacts = Contact::find($id);

        if($contacts){
            $this->array['result'] = $contacts;
        }else{
            $this->array['error'] = 'ID não encontrado';
        }

        return $this->array;
    }

    public function insert(Request $request){
        $name = $request -> input('name');
        $number = $request -> input('number');

        if($name && $number){
            $contact = new Contact();

            $contact -> name = $name;
            $contact -> number = $number;

            $contact->save();

            $this->array['result'] = [
                'id' => $contact-> id,
                'name' => $name,
                'number' => $number
            ];
        }else{
            $this->array['error'] = 'Campos não enviados';
        }
        return $this->array;
    }

    public function edit(Request $request, $id){
        $name = $request -> input('name');
        $number = $request -> input('number');

        if ($id && $name && $number){
            $contact = Contact::find($id);

            if($contact){
                $contact->name = $name;
                $contact->number = $number;
                $contact->save();

                $this->array['result'] = [
                    'id' => $id,
                    'name' => $name,
                    'number' => $number
                ];

            }else{
                $this->array['error'] = 'ID inexistente';
            }
        }else{
            $this->array['error'] = 'Campos nao enviados';
        }
        return $this->array;
    }

    public function delete($id){
        $contact = Contact::find($id);
        if($id){
            $contact->delete();
        }else{
            $this->array['error'] = 'ID inexistente';
        }
        return $this->array;
    }
}
