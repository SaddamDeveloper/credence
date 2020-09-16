@extends('admin.template.master')

@section('content')
 <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_content">

                  <section class="content invoice">
                        <div id="printableArea">
                      <!-- title row -->
                      <div class="row">
                        <div class="col-xs-12 invoice-header">
                           <h1>
                                <i class="fa fa-globe"></i> Invoice.
                                <small class="pull-right">Date: {{ date('d/m/Y') }}</small>
                            </h1>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- info row -->
                      <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                          From
                           <address>
                                <strong>Ciel Couture</strong>
                                <br>Guwahati, Assam
                                <br>Phone: 88638746953
                                <br>Email: info@cielcouture.com
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                          To
                          <address>
                                <strong>{{ $address->name }}</strong>
                                <br>{{ $address->address }}
                                <br>Phone: {{ $address->mobile_no }}
                                <br>Email: {{ $address->email }}
                                <br>City & PIN: {{ $address->city }}, {{ $address->pin_code }}
                                <br>State: {{ $address->state }}
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                          <b>Invoice</b>
                          <br>
                          <br>
                          <b>Order ID:</b> {{ $order->order_id }}
                          <br>
                          <b>Payment Due:</b> {{ \Carbon\Carbon::parse($order->created_at)->toDayDateTimeString() }}
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <!-- Table row -->
                      <div class="row">
                        <div class="col-xs-12 table">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th>Sl No</th>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Sub-Total</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @if(count($order_detail) > 0)
                                    @php
                                        $slno = 1;
                                        $total = 0;
                                    @endphp
                                    @foreach($order_detail as $key => $item)
                                    @php
                                        $sub_total = $item->price * $item->quantity;
                                        $total = $total + $sub_total;
                                    @endphp
                                    <tr>
                                        <td>{{ $slno++ }}</td>
                                        <td>{{ $item->stock->product->product_name }}</td>
                                        <td>{{ $item->stock->size }}</td>
                                        <td>{{ $item->stock->color->color}}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>₹ {{ number_format($item->price, 2) }}</td>
                                        <td>₹ {{ number_format($sub_total, 2) }}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                          </table>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-xs-6">
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-6">
                          <div class="table-responsive">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <th style="width:50%">Subtotal:</th>
                                  <td>₹ {{ number_format($total, 2) }}</td>
                                </tr>
                                <tr>
                                  <th>Shipping:</th>
                                  <td></td>
                                </tr>
                                <tr>
                                  <th>Total:</th>
                                  <td>₹ {{ number_format($total, 2) }}</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                    </div>
                      <!-- this row will not appear when printing -->
                      <div class="row no-print">
                        <div class="col-xs-12">
                          <button class="btn btn-default" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</button>
                          <a class="btn btn-warning" onclick="window.close();">Close</a>
                        </div>
                      </div>
                  
                    </section>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
@endsection

@section('script')
<script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    document.title = "Invoice";
    window.print();
    document.url = "";

    document.body.innerHTML = originalContents;
}
</script>
@endsection
