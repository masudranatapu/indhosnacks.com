@extends('admin.index')
@section('content')
<style>
    .table td,
    .table th {
        vertical-align: middle
    }
</style>
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>{{__('Testimonials')}}</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li class="active">{{__('Testimonials')}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="javascript:void(0)" class="btn btn-primary btn-flat m-b-30 m-t-30" data-toggle="modal"
                        data-target="#addTestimonial">Add New</a>
                    <div class="table-responsive dtdiv">
                        <table class="table table-striped dttablewidth">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Image</th>
                                    <th width="10%">Name</th>
                                    <th width="45%">Details</th>
                                    <th width="10%">Status</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><img src="{{ asset('public/upload/images/no-image.jpg') }}"
                                            class="border rounded" width="50" height="50" alt="">
                                    </td>
                                    <td>John Doe</td>
                                    <td>
                                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quisquam quas nesciunt
                                        accusantium earum minima quis fuga facilis, vero...........
                                    </td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a data-toggle="modal" data-target="#showTestimonial"><i
                                                class="fa fa-eye"></i></a>
                                        <a class="mr-2 ml-2" data-toggle="modal" data-target="#editTestimonial"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="#" onclick="return confirm('Are you sure to want to delete?');"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><img src="{{ asset('public/upload/images/no-image.jpg') }}"
                                            class="border rounded" width="50" height="50" alt="">
                                    </td>
                                    <td>John Doe</td>
                                    <td>
                                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quisquam quas nesciunt
                                        accusantium earum minima quis fuga facilis, vero...........
                                    </td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a data-toggle="modal" data-target="#showTestimonial"><i
                                                class="fa fa-eye"></i></a>
                                        <a class="mr-2 ml-2" data-toggle="modal" data-target="#editTestimonial"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="#" onclick="return confirm('Are you sure to want to delete?');"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- Testimonial Add Modal -->
<div class="modal fade" id="addTestimonial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Testimonial</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" class="row" method="post" enctype="multipart/form-data">
                    <div class="form-group col-12">
                        <label for="image" class="form-label">Image <span class="text-danger">* (Recommended
                                Size:
                                80*80px)</span>
                        </label>
                        <input type="file" name="image" id="image" class="form-control" required>
                    </div>

                    <div class="form-group col-12">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group col-12">
                        <label for="details" class="form-label">Details</label>
                        <textarea name="details" id="details" cols="30" rows="5" class="form-control"
                            required></textarea>
                    </div>

                    <div class="form-group col-12">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="" class="d-none">-- Select One --</option>
                            <option value="1">Published</option>
                            <option value="0">Unpublished</option>
                        </select>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary btn-md form-control">Add</button>
                        </div>
                        <div class="col-md-6">
                            <input type="button" class="btn btn-secondary btn-md form-control" data-dismiss="modal"
                                value="Close">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Testimonial Edit Modal -->
<div class="modal fade" id="editTestimonial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Testimonial</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" class="row" method="post" enctype="multipart/form-data">
                    <div class="form-group col-12">
                        <img src="{{ asset('public/upload/images/no-image.jpg') }}" class="border rounded" width="80"
                            height="80" alt="">
                    </div>
                    <div class="form-group col-12">
                        <label for="image" class="form-label">Image <span class="text-danger">* (Recommended
                                Size:
                                80*80px)</span>
                        </label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                    <div class="form-group col-12">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>

                    <div class="form-group col-12">
                        <label for="details" class="form-label">Details</label>
                        <textarea name="details" id="details" cols="30" rows="5" class="form-control"></textarea>
                    </div>

                    <div class="form-group col-12">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control">
                            <option value="" class="d-none">-- Select One --</option>
                            <option value="1">Published</option>
                            <option value="0">Unpublished</option>
                        </select>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary btn-md form-control">Add</button>
                        </div>
                        <div class="col-md-6">
                            <input type="button" class="btn btn-secondary btn-md form-control" data-dismiss="modal"
                                value="Close">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<!-- Testimonial Show Modal -->
<div class="modal fade" id="showTestimonial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">view Testimonial</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <td>Image:</td>
                        <td> <img src="{{ asset('public/upload/images/no-image.jpg') }}" class="border rounded"
                                width="80" height="80" alt=""></td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td>John Doe</td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td><span class="badge badge-success">Active</span></td>
                    </tr>
                    <tr>
                        <td>Details:</td>
                        <td>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Culpa qui dolorem ipsam sed
                            consequatur, quos numquam laborum quas debitis facere amet, provident ipsum recusandae
                            ducimus minima dicta impedit fugit vero. </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
