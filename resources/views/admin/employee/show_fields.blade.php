<!-- Id Field -->
<div class="form-group">
    <label>Id:</label>
    <p>{!! $employee->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    <label>Name: </label>
    <p>{!! $employee->name !!}</p>
</div>

<!-- phone Field -->
<div class="form-group">
    <label>Phone:</label>
    <p>
        {{ $employee->phone }}
    </p>
</div>

<!-- company Field -->
<div class="form-group">
    <label>Company:</label>
    <p>
        {{ optional($employee->company)->name }}
    </p>
</div>

<!-- email Field -->
<div class="form-group">
    <label>Email:</label>
    <p>@if ($employee->email)
            <a href="mailto:{{$employee->email}}"> {{$employee->email}}</a>
        @endif</p>
</div>
<!-- Created At Field -->
<div class="form-group">
    <label>Created At:</label>
    <p>{!! $employee->created_at->format('d.m.Y H:i') !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    <label>Updated at:</label>
    <p>{!! $employee->updated_at->format('d.m.Y H:i') !!}</p>
</div>

