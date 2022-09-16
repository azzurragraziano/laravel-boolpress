<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lead;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactThankYouEmail;

class LeadController extends Controller
{
    public function store(Request $request) {
        $data = $request->all();

        //valido i dati
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|max:60000'
        ]);

        //se la validazione non va a buon fine
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        //salvo i dati nel db
        $new_lead = new Lead();
        $new_lead->fill($data);
        $new_lead->save();

        //invio mail di ringraziamento
        Mail::to($data['email'])->send(new ContactThankYouEmail());

        return response()->json([
            'success' => true
        ]);
    }
}
