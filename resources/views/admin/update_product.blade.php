<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <base href="/public">
    @include('admin.css')
    <style type="text/css">
        .div_center {
            text-align: center;
            padding-top: 40px;
        }
        .font_size {
            font-size: 40px;
            padding-bottom: 40px;
        }
        .text_color {
            color: black;
            padding-bottom: 20px;
        }
        label {
            display: inline-block;
            width: 200px;
        }
        .div_design {
            padding-bottom: 15px;
        }
        .current_img {
            height: 100px;
            width: 100px;
            margin: auto;
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
            <div class="div_center">
                <h1 class="font_size">Add Product</h1>
                <form action="{{url('/update_product_confirm', $product->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="div_design">
                        <label>Product Name :</label>
                        <input class="text_color" type="text" name="name" placeholder="Product Name" required="" value="{{$product->name}}">
                    </div>
                    <div class="div_design">
                        <label>Product Description :</label>
                        <input class="text_color" type="text" name="description" placeholder="Product Description" required="" value="{{$product->description}}">
                    </div>
                    <div class="div_design">
                        <label>Product Price :</label>
                        <input class="text_color" type="number" name="price" placeholder="Product Price" required="" value="{{$product->price}}">
                    </div>
                    <div class="div_design">
                        <label>Product Category :</label>
                        <select class="text_color" name="category" required="">
                            <option value="{{$product->category}}" selected="">{{$product->category}}</option>  
                            @foreach($category as $category)
                            <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="div_design">
                        <label>Product Quantity :</label>
                        <input class="text_color" type="number" name="quantity" placeholder="Product Quantity" required="" value="{{$product->quantity}}">
                    </div>
                    <div class="div_design">
                        <label>Add Discount Price :</label>
                        <input class="text_color" type="text" name="discount_price" placeholder="Add Discount Price" value="{{$product->discount_price}}">
                    </div>

                    <div class="div_design">
                        <label>Current Image</label>
                        <img class="current_img" src="/product/{{$product->image}}">
                    </div>

                    <div class="div_design">
                        <label>Change Image</label>
                        <input type="file" name="image"  value="{{$product->image}}">
                    </div>
                    <div class="div_design">
                        <input type="submit" class="btn btn-primary" value="Update Product">
                    </div>
                </form>
                
            </div>
          </div>
        </div>
        

        <!-- container-scroller -->
        <!-- plugins:js -->
        @include('admin.script')
        <!-- End custom js for this page -->
</body>
</html>


