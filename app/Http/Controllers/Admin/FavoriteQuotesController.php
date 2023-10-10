<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;
use Inertia\Inertia;


class FavoriteQuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
    	$user = auth()->user();
    	$user = $user->load('favoriteQuotes');
    	
    	return Inertia::render('Favorites/Index', compact('user'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
    	$quote = Quote::find($id);
        $quote->users()->detach();
        $quote->delete();
        return redirect()->route('favorites.index');
    }
}
