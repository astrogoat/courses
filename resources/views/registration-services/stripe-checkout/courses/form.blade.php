<div>
    <x-fab::forms.select
        wire:model="course.registration_service.price_id"
        label="Course/Product"
    >
        <option disabled value="">-- Select a product --</option>
        @foreach($this->getProducts() as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
    </x-fab::forms.select>

    <x-fab::forms.toggle
        class="mt-4"
        label="Allow Promotion Codes"
        wire:model="course.registration_service.allow_promotion_codes"
        :toggled="$this->course->registration_service['allow_promotion_codes'] ?? false"
    />
</div>
