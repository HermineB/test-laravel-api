@extends('layout')

@section('content')
    <div class="content">
        <div class="container">
            <form action="/products/createProduct" class="mt-5">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" id="name" name="name" placeholder="name"/>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input class="form-control" id="description" name="description" placeholder="description"/>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input class="form-control" id="price" name="price" placeholder="price"/>
                </div>
                <div class="form-group">
                    <label for="quantity">quantity</label>
                    <input class="form-control" id="quantity" name="quantity" placeholder="quantity"/>
                </div>
                <div class="form-group">
                    <label for="categories">Categories</label>
                    <textarea class="form-control" id="categories" name="categories"> </textarea>
                </div>
                <div class="form-group">
                    <label for="external_id">External id</label>
                    <input class="form-control" id="external_id" name="external_id" placeholder="external_id"/>
                </div>
                <div class="form-group">
                    <input type="submit" value="Submit" />
                </div>
            </form>
        </div>
    </div>
@endsection
