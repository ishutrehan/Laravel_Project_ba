@extends('layouts.main')
@section('pageTitle', 'Payments')

@section('head')

@stop

@section('content')
 <div class="container">
      <div class="section_full_rw padding_tp-botm wp100">
        <div class="pay_main">
          <table border="1" class="payment">
            <thead>
              <tr>
                <th>id</th>
                <th>Amount</th>
                <th>currency</th>
                <th>status</th>
                <th>Invoice</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              foreach ($payments as $key => $payment) {
                $paymentdata = unserialize($payment->data);
                ?>
                <tr>
                  <td>{{$paymentdata['source']['id']}}</td>
                  <td>{{$paymentdata['amount']}}</td>
                  <td>{{$paymentdata['currency']}}</td>
                  <td>{{$paymentdata['status']}}</td>
                  <td><a href="{{route('user.invoice-page',['id'=> $payment->id])}}"> <b>Get Invoice</b></a></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
   
@stop