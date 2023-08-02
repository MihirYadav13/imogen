<div class="taxonomy-filter filter-input">
    <h6>{{ ($taxonomyFilterLabels[$filter]?:'') }}</h6>
    <select class="bs-multiselect" name="{{ $filter }}" multiple multiselect-config='{"numberDisplayed":1}'>
        @foreach($options as $option)
            <option value="{{ $option['key'] }}" {{ in_array($option['key'], isset($defaultFilters[$filter])?$defaultFilters[$filter]:[])?'selected':'' }}>{{ $option['value'] }}</option>
        @endforeach
    </select>
</div>