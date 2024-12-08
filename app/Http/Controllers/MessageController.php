<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Inertia\Inertia;

class MessageController extends Controller
{
    // Mostrar la vista de chat para una conversación
    
    public function show(User $users)
    {
        // Recuperar los mensajes de la conversación entre el usuario autenticado y el otro usuario
        $messages = Message::where(function ($query) use ($users) {
            $query->where('sender_id', auth()->user()->id)
                  ->where('receiver_id', $users->id);
        })->orWhere(function ($query) use ($users) {
            $query->where('sender_id', $users->id)
                  ->where('receiver_id', auth()->user()->id);
        })->orderBy('created_at', 'asc')->get();

        return Inertia::render('Message/Chat', [
            'messages' => $messages,
            'users' => $users,
        ]);
    }

    // Enviar un mensaje en una conversación
    public function sendMessage(Request $request, User $users)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        // Crear y almacenar el nuevo mensaje en la base de datos
        Message::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $users->id,
            'content' => $request->input('content'),
        ]);

        // Redirigir de vuelta a la vista de chat
        return redirect()->route('message.show', $users);
    }
}
