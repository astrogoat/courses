@php
    use Astrogoat\Courses\Models\Course;
    $brickKey = isset($repeaterBrickName) ? "{$repeaterBrickName}.{$index}.{$brickName}" : $brickName;
@endphp
<div>
    <x-fab::forms.select x-on:change="$wire.set('{{ $brickKey }}', $event.target.value)">
        <option @if(blank($this->get($brickKey)->getValue())) selected="selected" @endif disabled value="">-- Select a course --</option>
        @foreach(Course::all()->pluck('title', 'id')->toArray() as $id => $title)
            <option @if($this->get($brickKey)->getValue() == $id) selected="selected" @endif value="{{ $id }}">{{ $title }}</option>
        @endforeach
    </x-fab::forms.select>
</div>
