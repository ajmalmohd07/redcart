<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('admin.css')

    <style type="text/css">
        .title 
        {
            text-align: center;
            font-size: 25px;
            font-weight: bold;
            padding-bottom: 40px;
        }
        .table_design
        {
            border: 2px solid white;
            width: 100%;
            margin: auto;
            text-align: center;
        }
        .th_deg
        {
            background-color: skyblue;
        }
        .img_size
        {
            width: 200px;
            height: 100px;
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
            <h1 class="title">All Orders</h1>
            <div style="padding-left: 900px; padding-bottom:30px">
                <form action="{{url('search')}}" method="GET">
                    @csrf
                    
                    <input type="text" name="search" placeholder="search for something" style="color:black;">
                    <input type="submit" value="search" class="btn btn-outline-primary">
                </form>
            </div>
            <table class="table_design">
                <tr class="th_deg">
                    <th style="padding: 10px;">Name</th>
                    <th style="padding: 10px;">Phone</th>
                    <th style="padding: 10px;">Email</th>
                    <th style="padding: 10px;">Address</th>
                    <th style="padding: 10px;">Product Name</th>
                    <th style="padding: 10px;">Quantity</th>
                    <th style="padding: 10px;">Price</th>
                    <th style="padding: 10px;">Payment Status	</th>
                    <th style="padding: 10px;">Delivery Status</th>
                    <th style="padding: 10px;">Image</th>
                    <th style="padding: 10px;">Delivered</th>
                    <th style="padding: 10px;">Pdf</th>
                    <th style="padding: 10px;">Send Email</th>
                </tr>
                @forelse($order as $orders)
                <tr>
                    <td>{{$orders->name}}</td>
                    <td>{{$orders->phone}}</td>
                    <td>{{$orders->email}}</td>
                    <td>{{$orders->address}}</td>
                    <td>{{$orders->product_name}}</td>
                    <td>{{$orders->quantity}}</td>
                    <td>{{$orders->price}}</td>
                    <td>{{$orders->payment_status}}</td>
                    <td>{{$orders->delivery_status}}</td>
                    <td>
                        <img class="img_size" src="/product/{{$orders->image}}">
                    </td>
                    <td>
                        @if($orders->delivery_status=='processing')
                        <a href="{{url('delivered', $orders->id)}}" onclick="return comfirm('Are you sure this product is delivered !!!')" class="btn btn-primary">Delivered</a>
                        @else
                        <p style="color: green;">Delivered</p>
                        @endif
                    </td>
                    <td>
                        <a href="{{url('print_pdf', $orders->id)}}" class="btn btn-secondary">Print</a>
                    </td>
                    <td>
                        <a href="{{url('send_email', $orders->id)}}" class="btn btn-info">Send</a>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="16">No Data Found</td>
                </tr>
                @endforelse
            </table>
        </div>
    </div>
        
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>