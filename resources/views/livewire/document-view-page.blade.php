<div>
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-8">
            <div class="card">
                <div class="card-img-top">
                    <img class="img-fluid" src="{{asset('/public/storage').'/'.$row->file}}" alt="Card image cap" />
                </div>
                <div class="card-body">
                    <h5 class="card-title">Document Type</h5>
                    <p class="card-text">{{$row->type}}</p>
                    @if($row->status == 1)
                    <span class="badge rounded-pill bg-success">Approved</span>
                    @elseif($row->status == 2)
                    <span class="badge rounded-pill bg-danger">Rejected</span>
                    @else
                    <span class="badge rounded-pill bg-info">In-Review</span>
                    @endif
                </div>
                <div class="card-body">
                    @if(role_name(Auth::user()->id) == 'Administrator')
                    <div class="btn-group gap-2">
                        <a class="card-link btn btn-success btn-sm" class="" href="#!" wire:click="approve({{$row->id}})">Approve</a>
                        <a class="card-link btn btn-danger btn-sm" href="#!" wire:click="reject({{$row->id}})">Reject</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
