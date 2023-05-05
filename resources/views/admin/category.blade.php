<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('admin.css')
    <style>
        .div_center {
            text-align: center;
            padding-top: 40px;
        }
        .h2_font {
            font-size: 40px;
            padding-bottom: 40px;
        }
        .input_color {
            color: black;
        }
        .center {
            margin: auto;
            width: 50%;
            text-align: center;
            margin-top: 30px;
            border: 3px solid white;
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
                <h2 class="h2_font">Add Category</h2>
                
                <form action="{{url('/add_category')}}" method="GET">
                    @csrf
                    <input type="name" class="input_color" name="category" placeholder="category name">
                    <input type="submit" class="btn btn-primary" value="Add">
                </form>
            </div>
            <table class="center">
                <tr>
                    <td>Category Name</td>
                    <td>Action</td>
                </tr>
                @foreach($data as $datas)
                <tr>
                    <th>{{$datas->category_name}}</th>
                    <th>
                        <a class="btn btn-danger" href="{{url('/delete_category', $datas->id)}}">Delete</a>
                    </th>
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