<?php

namespace App\Http\Controllers;

use App\Models\News_letter;
use Illuminate\Http\Request;

class News_letterController extends Controller
{
    public function create()
    {
        return view('news_letter.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'sujet' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        News_letter::create($request->all());

        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès !');
    }
    public function index()
    {
        // Récupération des contacts, triés par date décroissante
        $contacts = News_letter::orderBy('created_at', 'desc')->get();

        return view('admin.news_letter', compact('contacts'));
    }
}
