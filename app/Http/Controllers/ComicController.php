<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Http\Requests\StoreComicRequest;
use App\Http\Requests\UpdateComicRequest;
use Illuminate\Validation\Rule; //attenzione qui, di default importa use errato

class ComicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $comics = Comic::all();

        return view('comics.index', compact('comics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $types = [
            'comic book' => 'Comic book',
            'graphic novel' => 'Graphic novel'
        ];

        return view('comics.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreComicRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComicRequest $request)
    {

        //inizio validazione, mettere in cima al method
        //una validazione per ogni campo
        $data = $request->validate([
            'title' => 'required|string|max:255|min:4',
            'description' => 'required|string|max:3000|min:10',
            'thumb' => 'required|string|url',
            'price' => 'required|decimal:2',
            'series' => 'required|string',
            'sale_date' => 'required|date_format:Y-m-d',
            'type' => [
                'required',
                Rule::in([
                    'comic book', 'graphic novel'
                ])
            ]
            //Rule::in([]) permette un check di specifiche parole (vedi select)
        ]);
        //se validazione fail, laravel rimanda a pag prec (create)
        //e salva in sessione gli errori

        //complete version (same on update)
        // $data = $request->all();

        // $new_comic = new Comic();

        // $new_comic->title = $data['title'];
        // $new_comic->description = $data['description'];
        // $new_comic->thumb = $data['thumb'];
        // $new_comic->price = $data['price'];
        // $new_comic->series = $data['series'];
        // $new_comic->sale_date = $data['sale_date'];
        // $new_comic->type = $data['type'];

        // $new_comic->save();

        //shortcut
        $new_comic = Comic::create($data); //cosi abbiamo errore fillable
        //lo risolviamo nel Model file

        return to_route('comics.show', $new_comic->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comic  $comic
     * @return \Illuminate\Http\Response
     */
    public function show(Comic $comic)
    {
        return view('comics.show', compact('comic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comic  $comic
     * @return \Illuminate\Http\Response
     */
    public function edit(Comic $comic)
    {

        $types = [
            'comic book' => 'Comic book',
            'graphic novel' => 'Graphic novel'
        ];

        return view('comics.edit', compact('comic', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateComicRequest  $request
     * @param  \App\Models\Comic  $comic
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComicRequest $request, Comic $comic)
    {

        $data = $request->validate([
            'title' => 'required|string|max:255|min:4',
            'description' => 'required|string|max:3000',
            'thumb' => 'required|string|url',
            'price' => 'required|decimal:2',
            'series' => 'required|string',
            'sale_date' => 'required|date_format:Y-m-d',
            'type' => [
                'required',
                Rule::in([
                    'comic book', 'graphic novel'
                ])
            ]
        ]);

        //metodo completo-----------------

        //shortcut 1----------------------
        // $comic->fill($data);
        // $comic->sav();

        //shortcut 2----------------------
        $comic->update($data);

        return to_route('comics.show', $comic->id);
    }

    public function delete(Comic $comic)
    {

        return view('comics.delete', compact('comic'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comic  $comic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comic $comic)
    {
        $comic->delete();

        return to_route('comics.index');
    }
}