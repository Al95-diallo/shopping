@extends('layout.main') @section('content')
<div class="row">  
    <div class="col-md-4">
        <form action="{{ route('biller.search') }}" id="lims_biller_search"  method="get" name="lims_biller_search">
            @csrf          
            <div class="search-box input-group">
            	<button class="btn btn-primary"><i class="fa fa-search"></i></button>       
            <input class="form-control" type="text" name="lims_billerTitleSearch" id="lims_billerTitleSearch" placeholder="Type company name and click...">
            </div>
        </form>      
    </div>
    <div class="col-md-3">
    	<div class="input-group">
          <div class="input-group-prepend">
          	<input type="text" disabled="" placeholder="Select Your Options..." class="form-control">
            <button data-toggle="dropdown" type="button" class="btn btn-outline-secondary dropdown-toggle"><span class="caret"></span></button>
            <div class="dropdown-menu">
            	<a href="{{route('biller.create')}}" class="dropdown-item">Add Biller</a>
            	<a href="#" data-toggle="modal" data-target="#importbiller" class="dropdown-item">Import biller</a>
            	{{ Form::open(['route' => 'biller.export', 'method' => 'post'] ) }}
            	<a href="" id="export" class="dropdown-item">Export To CSV File</a>
            </div>
          </div>    
        </div>
    </div>

	<div class="col-md-3">
        <div class="btn-toolbar pull-right">
          <div class="btn-group">{{ $lims_biller_all->links() }}</div>
      	</div>
          
    </div>
</div>

<div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select_all" value="-1"> Export</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Company Name</th>
                    <th>VAT Number</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Postal Code</th>
                    <th>Country</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_biller_all as $biller)
                <tr>
                    <td>
                        <input type="checkbox" name="biller[]" value="{{$biller->id}}">
                    </td>
                    <td>{{ $biller->name }}</td>
                    @if($biller->image)
                    <td> <img src="{{url('images',$biller->image)}}" height="80" width="80">
                    </td>
                    @else
                    <td>No Image</td>
                    @endif
                    <td>{{ $biller->company_name}}</td>
                    <td>{{ $biller->vat_number}}</td>
                    <td>{{ $biller->email}}</td>
                    <td>{{ $biller->phone_number}}</td>
                    <td>{{ $biller->address}}</td>
                    <td>{{ $biller->city}}</td>
                    <td>{{ $biller->state}}</td>
                    <td>{{ $biller->postal_code}}</td>
                    <td>{{ $biller->country}}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default">Action</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-default pull-right" user="menu">
                                <li>
                                    <button class="btn btn-link"><a href="{{ route('biller.edit', ['id' => $biller->id]) }}"> Edit</a></button> 
                                </li>
                                <li class="divider"></li>
                                {{ Form::open(['route' => ['biller.destroy', $biller->id], 'method' => 'DELETE'] ) }}
                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"> Delete</button>
                                </li>
                                {{ Form::close() }}
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="importbiller" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        {!! Form::open(['route' => 'biller.import', 'method' => 'post', 'files' => true]) !!}
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">Import Biller</h5>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <p>The field labels marked with * are required input fields.</p>
           <p>The correct column order is (name*, image, company_name*, vat_number, email*, phone_number*, address*, city*,state, postal_code, country) &you must follow this. Please make sure the csv file is UTF-8 encoded and not saved with byte order mark (BOM).</p>
            <label><strong>Upload File *</strong></label>
            <div class="form-group">
                {{Form::file('file', array('class' => 'form-control','required'))}}
            </div>
            <div class="form-group" id="operation_value"></div>
            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>
{{ Form::close() }}

<script type="text/javascript">
    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    var lims_biller_title = [ @foreach($lims_biller_list as $biller)
        <?php
            $billerTitleArray[] = $biller->company_name;
        ?>
         @endforeach
            <?php
            echo  '"'.implode('","', $billerTitleArray).'"';
            ?> ];
    var lims_billerTitleSearch = $('#lims_billerTitleSearch');

        lims_billerTitleSearch.autocomplete({
          source: function( request, response ) {
                  var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
                  response( $.grep( lims_biller_title, function( item ){
                      return matcher.test( item );
                  }) );
              },
          select: function(event,ui){
            lims_billerTitleSearch.val(ui.item.value);
            var lims_biller_search = $("#lims_biller_search");
            $("#lims_biller_search").submit();
            }
        });

        $( "#select_all" ).on( "change", function() {
            if ($(this).is(':checked')) {
                $("tbody input[type='checkbox']").prop('checked', true);
            } 
            else {
                $("tbody input[type='checkbox']").prop('checked', false);
            }
        });

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#export").on("click", function(e){
        e.preventDefault();
        var biller = [];
        $(':checkbox:checked').each(function(i){
          biller[i] = $(this).val();
        });
        $.ajax({
           type:'POST',
           url:'/exportbiller',
           data:{

                billerArray: biller
            },
           success:function(data){
            alert('Exported to CSV file successfully! Click Ok to download file');
            window.location.href = data;
           }
        });
    });
</script>
@endsection