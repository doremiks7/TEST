@extends('wallet.master')
@section('noidung')

<style type="text/css">
  .name-inname{
    display: none;
  }
  .imgae:hover .name-inname{
      display: block;
      position: absolute;
  }
</style>

  <h2>List Wallet</h2>
    @if(Session::has('flash-message'))
      <div class="alert alert-{!! Session::get('flash-level') !!}">       
          {!! Session::get('flash-message') !!}
      </div>
    @endif
  <div class="row">
    <p><button class="btn btn-primary" style="float:left; margin-bottom: 10px;" onclick="window.location='{{ URL::route('wallet.create') }}'"><i class="glyphicon glyphicon-plus-sign"> </i> Thêm mới </button></p>        
    <p><a href="{{ url('gettransfer') }}" class="btn btn-primary" style="float:right; margin-bottom: 10px;"> <i class="fa fa-usd" aria-hidden="true"></i> Chuyển tiền </a></p>
  </div>

 <div class="row">


    @foreach($wl as $value)
      <?php $react = ""; 
        if($value->amount > 10000000)
          { 
              $react = "happy_wallet";
          }else{ $react = "sad_wallet";}
        ?>
      <div class="post_aaz" style="display: inline-block; position: relative;">
        <a href="{{route('wallet_be_list', $value->id)}}" style="text-decoration:none;">
          <div role="button" class="imgae" style="background: url(public/img/wallet/{{$react}}.png); height: 158px;width: 250px; border-radius: 10px;">
            <div class="name-inname">
             <h4 style="padding-top: 10px; color: white;"> {{$value->name}}: <h4 style="color:white;">{{adddotstring($value->amount)}} vnđ</h4> </h4> 
          
              <form method="POST" action="{{route('wallet.destroy', $value->id)}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="_method" value="DELETE" />
                <input type="hidden" name="id" value="{{ $value->id }}" />
                <button onclick="return ConfirmDelete()" type="submit" class="btn btn-warning"><i class="fa fa-trash-o  fa-fw"></i>Delete</button>
              </form>

              <a href="{!! route('wallet.edit', $value->id) !!}" class="btn btn-info" role="button"><i class="fa fa-pencil fa-fw"></i>Edit </a>
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>
   

  <div class="pagination"></div>
<script type="text/javascript">
  function ConfirmDelete()
  {
    var x = confirm("Are you sure you want to delete?");
    if (x)
      return true;
    else
      return false;
  }
</script>
<script type="text/javascript">
    (function($){

    $(document).ready(function(){
      $(".pagination").customPaginate({
        itemsToPaginate : ".post_aaz"
      });
    });

})(jQuery);
</script>

@endsection