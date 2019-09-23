<!-- Id Field -->
<div class="form-group">
    <label>Id:</label>
    <p>{!! $company->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    <label>Name: </label>
    <p>{!! $company->name !!}</p>
</div>

<!-- website Field -->
<div class="form-group">
    <label>Website:</label>
    <p>
        @if ($company->website)
            <a href="{{ $company->website }}">{{ $company->website }}</a>
        @endif
    </p>
</div>

<!-- email Field -->
<div class="form-group">
    <label>Email:</label>
    <p>@if ($company->email)
            <a href="mailto:{{$company->email}}"> {{$company->email}}</a>
        @endif</p>
</div>

<!-- Image Field -->
<div class="form-group">
    <label>Logo</label>
    <p> @if ($company->logo)
            <img src="{{  asset('images/'.$company->logo)}}" alt="{{$company->name}}" width="80" height="80"/>
        @else
            <img src="https://via.placeholder.com/80/0000FF/808080" alt="{{$company->name}}" width="80" height="80"/>
        @endif</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    <label>Created At:</label>
    <p>{!! $company->created_at->format('d.m.Y H:i') !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    <label>Updated at:</label>
    <p>{!! $company->updated_at->format('d.m.Y H:i') !!}</p>
</div>

