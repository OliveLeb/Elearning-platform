<?php

namespace App\Http\Controllers;

use App\Course;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function store($id) {

        $course = Course::find($id);
        $wishlist = \Cart::session(Auth::user()->id . '_wishlist')->add([
            'id' => $course->id,
            'name' =>  $course->title,
            'price' =>  $course->price,
            'quantity' => 1,
            'associatedModel' => $course
        ]);
        return redirect()->back()->with('success','Ajouter à votre liste de souhait.');
    }

    public function destroy($id) {

        \Cart::session(Auth::user()->id . '_wishlist')->remove($id);
        return redirect()->back()->with('success', 'Article supprimé de votre liste de souhait');
    }

    public function toCart($id) {

        \Cart::session(Auth::user()->id . '_wishlist')->remove($id);
        $course = Course::find($id);
        $add = \Cart::session(Auth::user()->id)->add([
            'id' => $course->id,
            'name' =>  $course->title,
            'price' =>  $course->price,
            'quantity' => 1,
            'associatedModel' => $course
        ]);
        return redirect()->route('cart.index');
    }

    public function toWishList($id) {

        \Cart::session(Auth::user()->id)->remove($id);
        $course = Course::find($id);
        $add = \Cart::session(Auth::user()->id . '_wishlist')->add([
            'id' => $course->id,
            'name' =>  $course->title,
            'price' =>  $course->price,
            'quantity' => 1,
            'associatedModel' => $course
        ]);
        return redirect()->route('cart.index');
    }
}
