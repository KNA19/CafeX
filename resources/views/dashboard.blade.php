@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 p-3 text-center">
            <h3 class="animate__animated animate__bounce">Welcome {{ Auth()->user()->name }}, What Do You Want To Do</h3>
        </div>
        <div class="col-md-6 pt-2">
            <a href="{{ route('items') }}">
            <div class="card p-2 animate__animated animate__bounceIn" style="background: rgb(12, 12, 46)">
                <div class="card-body text-center text-white">
                    <h2>Item Management</h2>
                    <br>
                    <i class="fas fa-pizza-slice" style="font-size: 3.5rem"></i>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-3 pt-2">
            <a href="{{ route('makeOrder') }}">
            <div class="card p-2 animate__animated animate__bounceIn" style="background: rgb(12, 12, 46)">
                <div class="card-body text-center text-white">
                    <h2>Make Order</h2>
                    <br>
                    <i class="fas fa-utensils" style="font-size: 3.5rem"></i>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-3 pt-2">
            <a href="{{ route('confirmList') }}">
            <div class="card p-2 animate__animated animate__bounceIn" style="background: rgb(12, 12, 46)">
                <div class="card-body text-center text-white">
                    <h4>Confirmed Order</h4>
                    <br>
                    <i class="fas fa-utensils" style="font-size: 3.5rem"></i>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-3 pt-2">
            <a href="{{ route('account') }}">
            <div class="card p-2 animate__animated animate__bounceIn" style="background: rgb(12, 12, 46)">
                <div class="card-body text-center text-white">
                    <h2>Accounts</h2>
                    <br>
                    <i class="fas fa-file-invoice-dollar" style="font-size: 3.5rem"></i>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-3 pt-2">
            <a href="{{ route('waiterlist') }}">
            <div class="card p-2 animate__animated animate__bounceIn" style="background: rgb(12, 12, 46)">
                <div class="card-body text-center text-white">
                    <h2>Add Waiter</h2>
                    <br>
                    <i class="fas fa-user" style="font-size: 3.5rem"></i>
                </div>
            </div>
            </a>
        </div>
    </div>
</div>
@endsection
