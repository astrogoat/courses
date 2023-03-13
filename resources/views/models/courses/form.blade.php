@push('styles')
    @once
        <link href="{{ asset('vendor/courses/css/courses.css') }}" rel="stylesheet">
    @endonce
@endpush

<x-fab::layouts.page
    :title="$model->title ?: 'Untitled'"
    :breadcrumbs="[
        ['title' => 'Home', 'url' => route('lego.dashboard')],
        ['title' => 'Courses', 'url' => route('lego.courses.index')],
        ['title' => $model->title ?: 'New'],
    ]"
    x-data=""
    x-on:keydown.meta.s.window.prevent="$wire.call('save')" {{-- For Mac --}}
    x-on:keydown.ctrl.s.window.prevent="$wire.call('save')" {{-- For PC  --}}
>
    <x-slot name="actions">
        @include('lego::models._includes.forms.page-actions')
    </x-slot>

    <x-lego::feedback.errors class="course-mb-4" />

    <x-fab::layouts.main-with-aside>
        <x-fab::layouts.panel heading="Details">
            <x-fab::forms.input
                label="Title"
                wire:model.debounce.500ms="model.title"
                help="The title of the model. Will be used by search engines (i.e. Google or Bing) and in the browser tab."
            />

            <x-fab::forms.input
                wire:model.debounce.500ms="model.slug"
                label="URL and handle (slug)"
                :addon="url('') . Route::getRoutes()->getByName('courses.show')->getPrefix() . '/'"
                help="The URL where this page can viewed. Changing this will break any existing links users may have bookmarked."
                :disabled="! $model->exists"
            />

            <x-fab::forms.textarea
                wire:model.debounce.500ms="model.description"
                label="Description"
                help="Description of the course"
            />
        </x-fab::layouts.panel>

        <livewire:astrogoat.courses.http.livewire.models.courses.partials.participants :course="$this->model"/>
{{--        <x-fab::lists.table--}}
{{--            x-data="{participantStatusView: 'registered'}"--}}
{{--        >--}}
{{--            <x-slot name="title">--}}
{{--                <div class="course-flex course-items-center">--}}
{{--                    <div class="course-flex course-items-center course-justify-between course-flex-1">--}}
{{--                        <h2 class="course-text-base course-font-medium course-leading-6 course-text-gray-900">Participants</h2>--}}
{{--                    </div>--}}

{{--                    <fieldset class="">--}}
{{--                        <legend class="course-sr-only">View status</legend>--}}
{{--                        <div class="course-grid course-grid-cols-3 course-gap-3">--}}
{{--                            <!----}}
{{--                              In Stock: "course-cursor-pointer", Out of Stock: "course-opacity-25 course-cursor-not-allowed"--}}
{{--                              Active: "course-ring-2 course-ring-indigo-600 course-ring-offset-2"--}}
{{--                              Checked: "course-bg-indigo-600 course-text-white hover:course-bg-indigo-500",--}}
{{--                              Not Checked: "course-ring-1 course-ring-inset course-ring-gray-300 course-bg-white course-text-gray-900 hover:course-bg-gray-50"--}}
{{--                            -->--}}

{{--                            @foreach(['registered', 'waitList', 'abandoned'] as $status)--}}
{{--                                <label--}}
{{--                                    class="course-flex course-items-center course-justify-center course-rounded-md course-py-1.5 course-px-2 course-text-xs course-font-semibold course-uppercase sm:course-flex-1 course-cursor-pointer focus:course-outline-none"--}}
{{--                                    :class="[participantStatusView === '{{ $status }}' ? 'course-bg-indigo-600 course-text-white hover:course-bg-indigo-500' : 'course-ring-1 course-ring-inset course-ring-gray-300 course-bg-white course-text-gray-900 hover:course-bg-gray-50' ]"--}}
{{--                                >--}}
{{--                                    <input--}}
{{--                                        wire:model="participantStatusView"--}}
{{--                                        x-model="participantStatusView"--}}
{{--                                        type="radio"--}}
{{--                                        name="participant-status"--}}
{{--                                        value="{{ $status }}"--}}
{{--                                        class="course-sr-only"--}}
{{--                                        aria-labelledby="participant-status-{{ $loop->index }}-label"--}}
{{--                                    >--}}
{{--                                    <span id="participant-status-{{ $loop->index }}-label">{{ $status }}</span>--}}
{{--                                </label>--}}
{{--                            @endforeach--}}

{{--                            <!----}}
{{--                              In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"--}}
{{--                              Active: "ring-2 ring-indigo-600 ring-offset-2"--}}
{{--                              Checked: "bg-indigo-600 text-white hover:bg-indigo-500", Not Checked: "ring-1 ring-inset ring-gray-300 bg-white text-gray-900 hover:bg-gray-50"--}}
{{--                            -->--}}
{{--                            <label class="flex items-center justify-center rounded-md py-3 px-3 text-sm font-semibold uppercase sm:flex-1 cursor-pointer focus:outline-none ring-1 ring-inset ring-gray-300 bg-white text-gray-900 hover:bg-gray-50">--}}
{{--                                <input type="radio" name="memory-option" value="8 GB" class="sr-only" aria-labelledby="memory-option-1-label">--}}
{{--                                <span id="memory-option-1-label">8 GB</span>--}}
{{--                            </label>--}}

{{--                            <!----}}
{{--                              In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"--}}
{{--                              Active: "ring-2 ring-indigo-600 ring-offset-2"--}}
{{--                              Checked: "bg-indigo-600 text-white hover:bg-indigo-500", Not Checked: "ring-1 ring-inset ring-gray-300 bg-white text-gray-900 hover:bg-gray-50"--}}
{{--                            -->--}}
{{--                            <label class="flex items-center justify-center rounded-md py-3 px-3 text-sm font-semibold uppercase sm:flex-1 cursor-pointer focus:outline-none">--}}
{{--                                <input type="radio" name="memory-option" value="16 GB" class="sr-only" aria-labelledby="memory-option-2-label">--}}
{{--                                <span id="memory-option-2-label">16 GB</span>--}}
{{--                            </label>--}}

{{--                            <!----}}
{{--                              In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"--}}
{{--                              Active: "ring-2 ring-indigo-600 ring-offset-2"--}}
{{--                              Checked: "bg-indigo-600 text-white hover:bg-indigo-500", Not Checked: "ring-1 ring-inset ring-gray-300 bg-white text-gray-900 hover:bg-gray-50"--}}
{{--                            -->--}}
{{--                            <label class="flex items-center justify-center rounded-md py-3 px-3 text-sm font-semibold uppercase sm:flex-1 cursor-pointer focus:outline-none">--}}
{{--                                <input type="radio" name="memory-option" value="32 GB" class="sr-only" aria-labelledby="memory-option-3-label">--}}
{{--                                <span id="memory-option-3-label">32 GB</span>--}}
{{--                            </label>--}}

{{--                            <!----}}
{{--                              In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"--}}
{{--                              Active: "ring-2 ring-indigo-600 ring-offset-2"--}}
{{--                              Checked: "bg-indigo-600 text-white hover:bg-indigo-500", Not Checked: "ring-1 ring-inset ring-gray-300 bg-white text-gray-900 hover:bg-gray-50"--}}
{{--                            -->--}}
{{--                            <label class="flex items-center justify-center rounded-md py-3 px-3 text-sm font-semibold uppercase sm:flex-1 cursor-pointer focus:outline-none">--}}
{{--                                <input type="radio" name="memory-option" value="64 GB" class="sr-only" aria-labelledby="memory-option-4-label">--}}
{{--                                <span id="memory-option-4-label">64 GB</span>--}}
{{--                            </label>--}}

{{--                            <!----}}
{{--                              In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"--}}
{{--                              Active: "ring-2 ring-indigo-600 ring-offset-2"--}}
{{--                              Checked: "bg-indigo-600 text-white hover:bg-indigo-500", Not Checked: "ring-1 ring-inset ring-gray-300 bg-white text-gray-900 hover:bg-gray-50"--}}
{{--                            -->--}}
{{--                            <label class="flex items-center justify-center rounded-md py-3 px-3 text-sm font-semibold uppercase sm:flex-1 cursor-not-allowed opacity-25">--}}
{{--                                <input type="radio" name="memory-option" value="128 GB" disabled class="sr-only" aria-labelledby="memory-option-5-label">--}}
{{--                                <span id="memory-option-5-label">128 GB</span>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    </fieldset>--}}
{{--                </div>--}}
{{--            </x-slot>--}}
{{--            <x-slot name="headers">--}}
{{--                <x-fab::lists.table.header>Name</x-fab::lists.table.header>--}}
{{--                <x-fab::lists.table.header>Email</x-fab::lists.table.header>--}}
{{--                <x-fab::lists.table.header>Registration date</x-fab::lists.table.header>--}}
{{--                <x-fab::lists.table.header>Sign up date</x-fab::lists.table.header>--}}
{{--                <x-fab::lists.table.header :hidden="true"></x-fab::lists.table.header>--}}
{{--            </x-slot>--}}
{{--            @foreach($this->participants() as $participant)--}}
{{--                <x-fab::lists.table.row :odd="$loop->odd">--}}
{{--                    <x-fab::lists.table.column primary full>--}}
{{--                        {{ $participant->name }}--}}
{{--                    </x-fab::lists.table.column>--}}
{{--                    <x-fab::lists.table.column>{{ $participant->email }}</x-fab::lists.table.column>--}}
{{--                    <x-fab::lists.table.column>{{ $participant->registered_at?->toDayDateTimeString() }}</x-fab::lists.table.column>--}}
{{--                    <x-fab::lists.table.column align="right">--}}
{{--                        <x-fab::elements.button size="xs" slim>--}}
{{--                            <a href="{{ route('lego.products.variants.edit', [$model, $participant]) }}">Edit</a>--}}
{{--                        </x-fab::elements.button>--}}
{{--                    </x-fab::lists.table.column>--}}
{{--                </x-fab::lists.table.row>--}}
{{--            @endforeach--}}
{{--        </x-fab::lists.table>--}}

{{--        {{ $this->participants()->links() }}--}}

        <x-fab::layouts.panel heading="SEO">
            <x-fab::forms.textarea
                wire:model.debounce.500ms="model.meta.description"
                label="Description"
                help="Meta description for search engines like Google and Bing."
            />

            <x-fab::forms.checkbox
                id="should_index"
                label="Should be indexed"
                wire:model="model.indexable"
                help="If checked this will allow search engines (i.e. Google or Bing) to index the page so it can be found when searching on said search engine."
            />
        </x-fab::layouts.panel>

        @include('lego::metafields.define', ['metafieldable' => $model])

        <x-slot name="aside">
            <x-fab::layouts.panel heading="Structure">
                <x-fab::forms.select
                    wire:model="model.layout"
                    label="Layout"
                    help="The base layout for the model."
                >
                    <option disabled>-- Select layout</option>
                    @foreach(siteLayouts() as $key => $layout)
                        <option value="{{ $key }}">{{ $layout }}</option>
                    @endforeach
                </x-fab::forms.select>

                <x-fab::forms.select
                    wire:model="model.footer_id"
                    label="Footer"
                >
                    <option value="">No footer</option>
                    @foreach($this->footers() as $id => $footer)
                        <option value="{{ $id }}">{{ $footer }}</option>
                    @endforeach
                </x-fab::forms.select>
            </x-fab::layouts.panel>

            <x-fab::layouts.panel class="mt-4">
                <x-fab::forms.toggle
                    wire:model="model.is_open_for_registration"
                    label="Registation is open"
                    :toggled="$this->model->is_open_for_registration"
                    help="Toggle if you want to allow people to sign up for the course"
                />

                <x-fab::forms.toggle
                    wire:model="model.wait_list_enabled"
                    label="Enable wait list"
                    :toggled="$this->model->wait_list_enabled"
                    help="Toggle if you want to allow people to sign up for a wait list."
                />
            </x-fab::layouts.panel>

            <x-fab::layouts.panel class="mt-4">
                <x-fab::forms.select
                    label="Registration Service"
                    wire:model="registration_service_provider"
                    help="Select a service that handles course registration and potential payments."
                >
                    <option disabled value="">-- Select a service --</option>
                    @foreach($this->registrationServices() as $key => $name)
                        <option value="{{ $key }}">{{ $name }}</option>
                    @endforeach
                </x-fab::forms.select>

                @if($this->registrationServiceHasOptionsComponent())
                    {!! \Livewire\Livewire::mount($this->getRegistrationServiceOptionsComponent(), ['course' => $this->model])->html() !!}
                @endif
            </x-fab::layouts.panel>

            <x-lego::media-panel :model="$model" />
        </x-slot>
    </x-fab::layouts.main-with-aside>
</x-fab::layouts.page>
