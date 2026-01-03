<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\News_letter;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use App\Models\ActivityLog;

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

        $ip = request()->ip();
        $position = Location::get($ip);
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'news_letter',
            'description' => 'l\'utilisateur a envoyé un message via la newsletter.',
            'ip_address' => $ip,
            'pays'       => $position ? $position->countryName : null,
            'ville'      => $position ? $position->cityName : null,
            'latitude'   => $position ? $position->latitude : null,
            'longitude'  => $position ? $position->longitude : null,
            'code_pays'  => $position ? $position->countryCode : null,
            'user_agent' => request()->header('User-Agent'), // Navigateur et OS
        ]);


        if (Auth::check()) {

            // Utilisateur connecté
            if (Auth::user()->type_compte === 'client') {
                return redirect()
                    ->route('clients_historique')
                    ->with('success', 'Votre message a été envoyé avec succès !');
            }

            if (Auth::user()->type_compte === 'pro') {
                return redirect()
                    ->route('pro.dashboard')
                    ->with('success', 'Votre message a été envoyé avec succès !');
            }

            // Sécurité : si type inconnu
            return redirect()
                ->route('accueil')
                ->with('success', 'Votre message a été envoyé avec succès !');
        }

        // Utilisateur NON connecté
        return redirect()
            ->route('accueil')
            ->with('success', 'Votre message a été envoyé avec succès !');
    }
    public function index()
    {
        // Récupération des contacts, triés par date décroissante
        $contacts = News_letter::orderBy('created_at', 'desc')->get();

        return view('admin.news_letter', compact('contacts'));
    }
}
