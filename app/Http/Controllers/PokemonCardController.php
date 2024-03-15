<?php

namespace App\Http\Controllers;

use App\Models\PokemonCard;
use Illuminate\Http\Request;

class PokemonCardController extends Controller
{
    public function all()
    {
        return response()->json([
            'message' => 'All Products Returned',
            'data' => PokemonCard::all(),
        ]);

    }

    public function find(int $id)
    {
        return response()->json([
            'message' => 'Single Product Returned',
            'data' => PokemonCard::find($id),
        ]);
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

return response('Saved');
    }

    public function update(int $id, Request $request)
    {

        $cards = PokemonCard::find($id);

        if (! $cards) {
            return response()->json([
                'message' => 'Error invalid card ID',
            ]);
        }

        $request->validate([

            'name' => 'required|max:255|string',
            'HP' => 'required|integer',
            'FirstSkill' => 'required|max:255|string',
            'Weakness' => 'required|max:255|string',
            'Rating' => 'required|integer',
            'Got' => 'required|boolean',

        ]);

        $cards->name = $request->name;
        $cards->HP = $request->HP;
        $cards->FirstSkill = $request->FirstSkill;
        $cards->Weakness = $request->Weakness;
        $cards->Rating = $request->Rating;
        $cards->Got = $request->Got;

        if (! $cards->save()) {
            return response()->json([
                'message' => 'Product Not Updated',
            ]);
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
            ]);
        }

        $cards->delete();

        return response()->json([
            'message' => 'deleted',
        ]);

    }
}
