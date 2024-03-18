<?php

namespace App\Http\Controllers;

use App\Models\PokemonCard;
use Illuminate\Http\Request;

class PokemonCardController extends Controller
{
    public function all(Request $request)
    {


        $search = $request->search;

        if ($search) {

            return PokemonCard::where('name', 'LIKE', "%$search%")->get()->makeHidden(['id', 'HP', 'FirstSKill', 'Weakness', 'Rating', 'Got']);

        }

        if ($request->sort === 'asc') {
            return PokemonCard::orderBy('name', 'asc')->get();
        } else if ($request->sort === 'desc') {
            return PokemonCard::orderBy('name', 'desc')->get();
        }

        return response()->json([
            'message' => 'All Products Returned',
            'data' => PokemonCard::all(),
        ], 200);

    }

    public function find(int $id)
    {
        return response()->json([
            'message' => 'Single Product Returned',
            'data' => PokemonCard::find($id),
        ], 200);
    }

    public function create(Request $request)
    {

        $request->validate([

            'name' => 'required|max:255|string',
            'HP' => 'required|integer',
            'FirstSkill' => 'required|max:255|string',
            'Weakness' => 'required|max:255|string',
            'Rating' => 'required|integer',
            'Got' => 'required|boolean',
        ]);

        $cards = new PokemonCard();
        $cards->name = $request->name;
        $cards->HP = $request->HP;
        $cards->FirstSkill = $request->FirstSkill;
        $cards->Weakness = $request->Weakness;
        $cards->Rating = $request->Rating;
        $cards->Got = $request->Got;

        if (! $cards->save()) {
            return response()->json([
                'message' => 'Did not save',
            ], 500);
        }

        return response()->json([
            'message' => 'Saved',
        ], 401);
    }

    public function update(int $id, Request $request)
    {

        $cards = PokemonCard::find($id);

        if (! $cards) {
            return response()->json([
                'message' => 'Error invalid card ID',
            ], 400);
        }

        $request->validate([

            'name' => 'max:255|string',
            'HP' => 'integer',
            'FirstSKill' => 'max:255|string',
            'Weakness' => 'max:255|string',
            'Rating' => 'integer',
            'Got' => 'boolean',

        ]);

        if ($request->has('name')) {
            $cards->name = $request->name;
        }

        if ($request->has('HP')) {
            $cards->HP = $request->HP;
        }

        if ($request->has('FirstSKill')) {
            $cards->FirstSKill = $request->FirstSKill;
        }

        if ($request->has('Weakness')) {
            $cards->Weakness = $request->Weakness;
        }

        if ($request->has('Rating')) {
            $cards->Rating = $request->Rating;
        }

        if ($request->has('Got')) {
            $cards->Got = $request->Got;
        }

        if (! $cards->save()) {
            return response()->json([
                'message' => 'Product Not Updated',
            ], 500);
        }

        return response()->json([
            'message' => 'Product Updated',
        ]);
    }

    public function delete(int $id)
    {

        $cards = PokemonCard::find($id);

        if (! $cards) {
            return response()->json([
                'message' => 'Error invalid card ID',
            ], 400);
        }

        $cards->delete();

        return response()->json([
            'message' => 'deleted',
        ], 200);
    }

}
