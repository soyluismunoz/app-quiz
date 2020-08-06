<?php

namespace App\Http\Controllers;

use App\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function getParticipants()
    {
        //
    }

    public function addParticipant(Request $request)
    {
        $email = $request->email;
        $name = $request->name;

        $participant = Participant::where('email', $email)->pluck('id')->first();

        if(!$participant){
            $newParticipant = new Participant([
                'name'       => $name,
                'email'          => $email,
            ]);
            $newParticipant->save();
            return view('home', ['participant' => $newParticipant]);
        }else{
            $participant = Participant::find($participant);
            return view('home', ['participant' => $participant]);
        }
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Participant $participant)
    {
        //
    }

    public function edit(Participant $participant)
    {
        //
    }

    public function update(Request $request, Participant $participant)
    {
        //
    }

    public function destroy(Participant $participant)
    {
        //
    }
}
