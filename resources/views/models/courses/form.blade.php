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

    <x-lego::feedback.errors class="mb-4" />

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

        <x-fab::lists.table
            title="Participants"
        >
            <x-slot name="headers">
                <x-fab::lists.table.header>Name</x-fab::lists.table.header>
                <x-fab::lists.table.header>Email</x-fab::lists.table.header>
{{--                <x-fab::lists.table.header>Sign up date</x-fab::lists.table.header>--}}
{{--                <x-fab::lists.table.header :hidden="true"></x-fab::lists.table.header>--}}
            </x-slot>
            @foreach($this->participants() as $participant)
                <x-fab::lists.table.row :odd="$loop->odd">
                    <x-fab::lists.table.column primary full>
                        {{ $participant->name }}
                    </x-fab::lists.table.column>
                    <x-fab::lists.table.column>{{ $participant->email }}</x-fab::lists.table.column>
{{--                    <x-fab::lists.table.column align="right">--}}
{{--                        <x-fab::elements.button size="xs" slim>--}}
{{--                            <a href="{{ route('lego.products.variants.edit', [$model, $participant]) }}">Edit</a>--}}
{{--                        </x-fab::elements.button>--}}
{{--                    </x-fab::lists.table.column>--}}
                </x-fab::lists.table.row>
            @endforeach
        </x-fab::lists.table>

        {{ $this->participants()->links() }}

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
                    wire:model="model.registration_service.provider"
                    help="Select a service that handles course registration and potential payments."
                >
                    <option disabled value="">-- Select a service --</option>
                    @foreach($this->registrationServices() as $key => $name)
                        <option value="{{ $key }}">{{ $name }}</option>
                    @endforeach
                </x-fab::forms.select>

                @if(($this->model->registration_service['provider'] ?? '') == 'stripe-payment-link')
                    <x-fab::forms.input
                        label="Stripe Payment Link"
                        wire:model="model.registration_service.link"
                    />
                @endif
            </x-fab::layouts.panel>

            <x-lego::media-panel :model="$model" />
        </x-slot>
    </x-fab::layouts.main-with-aside>
</x-fab::layouts.page>
