<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-row justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Contacts') }}
            </h2>

            @include('contacts.forms.create')

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>{{ __("Contact Number") }}</th>
                                <th>{{ __("Contact Name") }}</th>
                                <th>{{ __("File attachment") }}</th>
                                <th>{{ __("Action") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $contact)
                            <tr>
                                <td>{{ $contact->number }}</td>
                                <td>{{ $contact->name }}</td>
                                <td><a href="{{asset('storage/'.$contact->file_path)}}">{{$contact->file_path}}</a></td>
                                <td>
                                    @include('contacts.forms.update')
                                    @include('contacts.forms.delete')
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>