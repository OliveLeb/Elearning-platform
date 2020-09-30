<?php

namespace App\Http\Controllers;

use App\Payment;
use Stripe\Charge;
use Stripe\Stripe;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Managers\PaymentManager;

class CheckoutController extends Controller
{
    public function __construct(PaymentManager $paymentManager) {
        $this->paymentManager = $paymentManager;
    }

    public function checkout() {
        return view('checkout.payment');
    }

    public function charge(Request $request) {

        \Stripe\Stripe::setApiKey(env('STRIPE_PRIVATE_KEY'));

        $cart = \Cart::session(Auth::user()->id);
        $tax = $cart->getTotal() / 5;
        $roundedTax = round($tax,2);


        try {
            $charge = \Stripe\Charge::create([
                'amount' => ($cart->getTotal() + $roundedTax) * 100,
                'currency' => 'EUR',
                'description' => 'Paiement via Elearning',
                'source' => $request->input('stripeToken'),
                'receipt_email' => Auth::user()->email
            ]);

            foreach(\Cart::getContent() as $item){
                $instructor_part = $this->paymentManager->getInstructorpart($cart->getTotal() + $roundedTax);
                $elearning_part = $this->paymentManager->getElearningpart($cart->getTotal() + $roundedTax);
                Payment::create([
                    'course_id' => $item->model->id,
                    'amount' => $cart->getTotal() + $roundedTax,
                    'instructor_part' => $instructor_part,
                    'elearning_part' => $elearning_part,
                    'email' => Auth::user()->email
                ]);
            }

            return redirect()->route('checkout.success')->with('success','Paiement accepté.');
        }
        catch(\Stripe\Exception\CardErrorException $error) {
            throw $error;
        }
    }

    public function success() {
        if(!session()->has('success')){
            return redirect()->route('main.home');
        }

        $order = \Cart::session(Auth::user()->id)->getContent();
        foreach(\Cart::session(Auth::user()->id)->getContent() as $cartItem) {
            \Cart::remove($cartItem->id);
        }

        return view('checkout.success',[
            'order'=> $order
        ]);
    }
}
