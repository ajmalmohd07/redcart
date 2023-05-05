<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Notifications\SendEmailNotification;
use Dompdf\Adapter\PDFLib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Notification;

class AdminController extends Controller
{
    public function view_category()
    {
        if(Auth::id())
        {
            $data = Category::all();
            return view('admin.category', compact('data'));
        }
        else
        {
            return redirect('login');
        }
        
    }

    public function add_category(Request $request)
    {
        $data = new category;
        $data->category_name = $request->category;
        $data->save();
        return redirect()->back()->with('message', 'category added successfully');
    }
    public function delete_category($id) {
        $data = Category::find($id);
        $data->delete();
        return redirect()->back()->with('message', 'category deleted successfully');
    }

    public function view_product()
    {
        $category = Category::all();
        return view('admin.product', compact('category'));
    }

    public function add_product(Request $request) 
    {
        $product = new product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category = $request->category;
        $product->discount_price = $request->discount_price;
        

        $image = $request->image;
        $imagename = time().'.'.$image->getClientOriginalExtension();
        $request->image->move('product', $imagename);
        $product->image = $imagename;

        $product->save();
        return redirect()->back()->with('message', 'product added successfully' );
    }

    public function show_product()
    {
        $product = Product::all();
        return view('admin.show_product', compact('product'));
    }

    public function delete_product($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->back()->with('message', 'product deleted successfully');
    }

    public function update_product($id)
    {
        $product = Product::find($id);
        $category = Category::all();
        return view('admin.update_product', compact('product', 'category'));
    }

    public function update_product_confirm(Request $request, $id)
    {
        if(Auth::id())
        {
            $product = Product::find($id);

            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->category = $request->category;
            $product->discount_price = $request->discount_price;

            $image = $request->image;
            if($image)
            {
                $imagename = time().'.'.$image->getClientOriginalExtension();
                $request->image->move('product', $imagename);
                $product->image = $imagename;
            }
            $product->save();
            return redirect()->back()->with('message', 'Product Updated Successfully');
        }
        else
        {
            return redirect('login');
        }
        
    }

    public function order()
    {
        $order = Order::all();
        return view('admin.order', compact('order'));
    } 

    public function delivered($id)
    {
        $order = Order::find($id);
        $order->delivery_status = "Delivered";
        $order->payment_status = "Paid";
        $order->save();
        return redirect()->back();
    }

    public function print_pdf($id)
    {
        $order = Order::find($id);
        $pdf = PDF::loadView('admin.pdf', compact('order'));
        return $pdf->download('order_details.pdf');
    }

    public function send_email($id)
    {
        $order = Order::find($id);
        return view('admin.email_info', compact('order'));
    }

    public function send_user_email(Request $request, $id)
    {
        $order = Order::find($id);

        $details = [
            'greeting' => $request->greeting,

            'firstline' => $request->firstline,

            'body' => $request->body,

            'firstline' => $request->firstline,

            'button' => $request->button,

            'url' => $request->url,

            'lastline' => $request->lastline,


        ];
        Notification::send($order,new SendEmailNotification($details));
        return redirect()->back();
    }

    public function searchdata(Request $request)
    {
        $searchtext = $request->search;

        $order = Order::where('name', $searchtext)->orWhere('phone', $searchtext)->get();
        
        return view('admin.order', compact('order'));
    }


}
