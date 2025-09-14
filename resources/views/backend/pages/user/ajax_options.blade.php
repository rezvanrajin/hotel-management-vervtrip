@if (isset($region_id))
    <option data-id="a" value="">Select Country</option>
@endif
@if (isset($country_id))
    <option data-id="a" value="">Select State</option>
@endif
@if (isset($state_id))
    <option data-id="a" value="">Select City</option>
@endif
@foreach ($data as $item)
    <option data-id="{{ $item->id }}" value="{{ $item->name }}">{{ $item->name }}</option>
@endforeach
