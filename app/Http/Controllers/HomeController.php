<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;

use Session;
use Stripe;


class HomeController extends Controller
{
    public function redirect() {
        $usertype = Auth::user()->usertype;
        if($usertype=='1') 
        {
            $total_products = Product::all()->count();
            $total_orders = Order::all()->count();
            $total_customers = User::all()->count();

            $order = Order::all();
            $total_revenue = 0;
            foreach($order as $orders)
            {
                $total_revenue = $total_revenue + $orders->price;
            }

            $total_delivered = Order::where('delivery_status','Delivered')->get()->count();

            $order_process = Order::where('delivery_status', 'processing')->get()->count();
            return view('admin.home', compact('total_products','total_orders', 'total_customers', 'total_revenue', 'total_delivered', 'order_process'));
        }
        else {
            $product = Product::paginate(3);
        return view('home.userpage', compact('product'));
        }
    }
    public function index()
    {
        $product = Product::paginate(3);
        return view('home.userpage', compact('product'));
    }

    public function product_details($id)
    {
        $product = Product::find($id);
        return view('home.product_details', compact('product'));

    }

    public function add_cart(Request $request, $id)
    {
        if(Auth::id())
        {
            $user = Auth::User();
            $userid = $user->id;
            $product = Product::find($id);
            $product_exist_id = Cart::where('product_id', $id)->where('user_id', $userid)->get('id')->first();

            if($product_exist_id)
            {
                $cart = Cart::find($product_exist_id)->first();
                $quantity = $cart->quantity;
                $cart->quantity = $quantity + $request->quantity;

                if($product->discount_price!=null)
                {
                    $cart->price = $product->discount_price * $cart->quantity;
                }
                else
                {
                    $cart->price = $product->price * $cart->quantity;
                }

                $cart->save();
                Alert::success('Product Added Successfully', 'We have added product to the cart');
                return redirect()->back()->with('message', 'Product Added Successfully');
            }
            else
            {
                $cart = new cart;
                $cart->name = $user->name;
                $cart->email = $user->email;
                $cart->phone = $user->phone;
                $cart->address = $user->address;
                $cart->user_id = $user->id;

                $cart->product_name = $product->name;
                if($product->discount_price!=null)
                {
                    $cart->price = $product->discount_price * $request->quantity;
                }
                else
                {
                    $cart->price = $product->price * $request->quantity;
                }
            
                $cart->quantity = $request->quantity;

                $cart->image = $product->image;
            
                $cart->product_id = $product->id;
                $cart->save();
                return redirect()->back()->with('message', 'Product Added Successfully');
            }

            
        }
        else
        {
            return redirect('login');

        }
    }

    public function show_cart()
    {
        if(Auth::id())
        {
            $id = Auth::user()->id;
            $cart = Cart::where('user_id', $id)->get();
            return view('home.showcart', compact('cart'));
        }
        else
        {
            return redirect('login');
        }
        
    }

    public function remove_cart($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        return redirect()->back();
    }

    public function cash_order()
    {
        $user = Auth::user();
        $userid = $user->id;

        $data = Cart::where('user_id', $userid)->get();
        
        foreach($data as $datas)
        {
            $order = new order;
            $order->name = $datas->name;
            $order->email = $datas->email;
            $order->phone = $datas->phone;
            $order->address = $datas->address;
            $order->user_id = $datas->user_id;

            $order->product_name = $datas->product_name;
            $order->quantity = $datas->quantity;
            $order->price = $datas->price;
            $order->image = $datas->image;
            $order->product_id = $datas->product_id;

            $order->payment_status = 'cash on delivery';
            $order->delivery_status = 'processing';

            $order->save();

            $cart_id=$datas->id;
            $cart = cart::find($cart_id);
            $cart->delete();
            

            
        }
        return redirect()->back()->with('message', 'We have recieved your order. We will connect with you soon.');
    }

    public function stripe($totalprice) 
    {
        return view('home.stripe', compact('totalprice'));
    }

    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => 100 * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);
      
        Session::flash('success', 'Payment successful!');
            
              
        return back();
    }

    public function show_order()
    {
        if(Auth::id())
        {
            $user = Auth::user();
            $userid = $user->id;

            $order = Order::where('user_id', $userid)->get();
            
            return view('home.order', compact('order'));
        }
        else
        {
            return redirect('login');
        }
    }

    public function cancel_order($id)
    {
        $order = Order::find($id);
        $order->delivery_status='You canceled the order';
        $order->save();
        return redirect()->back();
    }

    public function product_search(Request $request)
    {
        $search_text = $request->search;
        $product = Product::where('name', 'LIKE', "%$search_text%")->orWhere('category', 'LIKE', "$search_text")->paginate(10);
        return view('home.userpage',compact('product'));
    }
    public function products()
    {
        $product = Product::paginate(10);
        return view('home.all_products', compact('product'));
    }

    public function search_product(Request $request)
    {
        $search_text = $request->search;
        $product = Product::where('name', 'LIKE', "%$search_text%")->orWhere('category', 'LIKE', "$search_text")->paginate(10);
        return view('home.all_products',compact('product'));
    }
}
