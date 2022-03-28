<div class="col-md-6">

    <div class="form-group">


        @if ($label ?? null)
            <label class="{{ $required ?? false ? 'label label-required' : 'label' }}" for="{{ $name }}">
                {{ $label }}
            </label>
        @endif
        <input autocomplete="off" type="{{ $type ?? 'text' }}" name="{{ $name }}" id="{{ $name }}"
            class="form-control" placeholder="{{ $placeholder ?? '' }}" value="{{ old($name, $value ?? '') }}"
            {{ $required ?? false ? 'required' : '' }}>

        {{-- <input type="text" value="{{ old('name') }}" id="name"
        class="form-control" placeholder="input name" name="name"> --}}

        @error($name )
            <span class="text-danger">{{ $message }}</span>
        @enderror


    </div>
</div>
