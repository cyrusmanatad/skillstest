<div class="mt-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
        {{ $label }}
    </label>

    <select id="{{ $name }}" name="{{ $name }}" 
        {{-- @if ($disabled) disabled @endif --}}
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
        
        <option value="{{ $selected }}" @if (!$selected) selected @endif>{{ __('Select option') }}</option>

        @foreach ($options as $option)
            <option value="{{ $option['key'] }}" @if ($option['text'] == $selected) selected @endif>{{ $option['text'] }}</option>
        @endforeach
    </select>
</div>