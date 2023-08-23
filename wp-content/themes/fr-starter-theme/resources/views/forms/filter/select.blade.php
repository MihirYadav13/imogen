<div class="taxonomy-filter filter-input">
    <h6>{{ ($taxonomyFilterLabels[$filter]?:'') }}</h6>
    <select class="bs-multiselect {{ count($options) === 0 ? 'empty' : '' }}" name="{{ $filter }}" multiple multiselect-config='{"numberDisplayed":1}'>
        <option value="" class="default">{{ ($filterDefaultLabels[$filter]?:'All') }}</option>

        @foreach($options as $option)
            <option value="{{ $option['key'] }}" {{ in_array($option['key'], isset($defaultFilters[$filter])?$defaultFilters[$filter]:[])?'selected':'' }}>{{ $option['value'] }}</option>
        @endforeach
    </select>
</div>