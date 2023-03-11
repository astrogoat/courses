<x-fab::layouts.page
    title="Courses"
    :breadcrumbs="[
        ['title' => 'Home', 'url' => route('lego.dashboard')],
        ['title' => 'Courses','url' => route('lego.courses.index')],
    ]"
    x-data="{ showColumnFilters: false }"
>
    <x-slot name="actions">
        <x-fab::elements.button type="link" :url="route('lego.courses.create')">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span>New page</span>
        </x-fab::elements.button>
    </x-slot>

    @include('lego::models._includes.indexes.filters')

    <x-fab::lists.table>
        <x-slot name="headers">
            <x-fab::lists.table.header :hidden="true">Status</x-fab::lists.table.header>
            @include('lego::models._includes.indexes.headers')
            <x-fab::lists.table.header :hidden="true">Edit</x-fab::lists.table.header>
            <x-fab::lists.table.header :hidden="true">Customize</x-fab::lists.table.header>
        </x-slot>

        @include('lego::models._includes.indexes.header-filters')
        <x-fab::lists.table.header x-show="showColumnFilters" x-cloak class="bg-gray-100" />
        <x-fab::lists.table.header x-show="showColumnFilters" x-cloak class="bg-gray-100" />

        @foreach($models as $course)
            <x-fab::lists.table.row :odd="$loop->odd">
                <x-fab::lists.table.column>
                    <span class="inline-block h-2 w-2 flex-shrink-0 rounded-full {{ $this->courseStatusColor($course) }}" aria-hidden="true"></span>
                </x-fab::lists.table.column>

                @if($this->shouldShowColumn('title'))
                    <x-fab::lists.table.column primary full>
                        <a href="{{ route('lego.courses.edit', $course) }}">{{ $course->title }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('started_at'))
                    <x-fab::lists.table.column align="right">
                        {{ $course->started_at?->toFormattedDateString() }}
                    </x-fab::lists.table.column>
                @endisset

                @if($this->shouldShowColumn('ended_at'))
                    <x-fab::lists.table.column align="right">
                        {{ $course->ended_at?->toFormattedDateString() }}
                    </x-fab::lists.table.column>
                @endisset

                @if($this->shouldShowColumn('participants'))
                    <x-fab::lists.table.column>
                        {{ $course->participants->count() }}
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('updated_at'))
                    <x-fab::lists.table.column align="right">
                        {{ $course->updated_at->toFormattedDateString() }}
                    </x-fab::lists.table.column>
                @endisset

                <x-fab::lists.table.column align="right" slim>
                    <a href="{{ route('lego.courses.edit', $course) }}">Edit</a>
                </x-fab::lists.table.column>

                <x-fab::lists.table.column align="right">
                    <a href="{{ route('lego.courses.editor', $course) }}">Customize</a>
                </x-fab::lists.table.column>
            </x-fab::lists.table.row>
        @endforeach
    </x-fab::lists.table>

    @include('lego::models._includes.indexes.pagination')
</x-fab::layouts.page>
