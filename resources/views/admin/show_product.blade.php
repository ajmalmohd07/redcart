<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('admin.css')

    <style type="text/css">
        .center {
            margin: auto;
            width: 50%;
            border: 2px solid white;
            text-align: center;
            margin-top: 40px;
        }
        .font_size {
            text-align: center;
            font-size: 40px;
            padding-top: 20px;
        }
        .img_size {
            width: 150px;
            height: 150px;
        }
        .th_color {
            background: skyblue;
        }
        .th_design {
            padding: 30px;
        }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      @include('admin.header')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
            @if(session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{session()->get('message')}}
            </div>
            @endif
                <h1 class="font_size">All Products</h1>
                <table class="center">
                    <tr class="th_color">
                        <th class="th_design">Name</th>
                        <th class="th_design">Description</th>
                        <th class="th_design">Price</th>
                        <th class="th_design">Category</th>
                        <th class="th_design">Quantity</th>
                        <th class="th_design">Discount Price</th>
                        <th class="th_design">Image</th>
                        <th class="th_design">Edit</th>
                        <th class="th_design">Delete</th>
                    </tr>
                    @foreach($product as $product)
                    <tr>
                        <td>{{$product->name}}</td>
                        <td>{{$product->description}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->category}}</td>
                        <td>{{$product->quantity}}</td>
                        <td>{{$product->discount_price}}</td>
                        <td>
                            <img class="img_size" src="/product/{{$product->image}}">
                        </td>
                        <td>
                            <a class="btn btn-success" href="{{url('update_product', $product->id)}}">Edit</a> 
                        </td>
                        <td>
                            <a class="btn btn-danger" href="{{url('delete_product', $product->id)}}">delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>