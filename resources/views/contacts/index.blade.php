<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-row justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Contacts') }}
            </h2>

            <x-primary-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'add_contactForm')"
            >
                {{ __('Add') }}
            </x-primary-button>

            <x-modal name="add_contactForm" :show="$errors->contactCreation->isNotEmpty()">
                <form method="post" action="{{ route('contacts.store') }}" enctype="multipart/form-data" class="p-6">
                    @csrf

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Add contact') }}
                    </h2>

                    <div class="mt-6">
                        <x-input-label for="contact_number" value="{{ __('Contact Number') }}" class="sr-only" />

                        <x-text-input
                            id="contact_number"
                            name="contact_number"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="{{ __('Contact Number') }}"
                            :is_invalid="$errors->contactCreation->has('contact_number')"
                        />

                        <x-input-error :messages="$errors->contactCreation->get('contact_number')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-input-label for="contact_name" value="{{ __('Contact Name') }}" class="sr-only" />

                        <x-text-input
                            id="contact_name"
                            name="contact_name"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="{{ __('Contact Name') }}"
                            :is_invalid="$errors->contactCreation->has('contact_name')"
                        />

                        <x-input-error :messages="$errors->contactCreation->get('contact_name')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-input-label for="fileAttachment" value="{{ __('Contact Name') }}" class="sr-only" />

                        <x-file-upload
                            id="fileAttachment"
                            name="fileAttachment"
                            type="file"
                            class="mt-1 block w-full"
                            placeholder="{{ __('File attachment') }}"
                            :is_invalid="$errors->contactCreation->has('fileAttachment')"
                        />

                        <x-input-error :messages="$errors->contactCreation->get('fileAttachment')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-primary-button class="ms-3">
                            {{ __('Submit') }}
                        </x-primary-button>
                    </div>
                </form>
            </x-modal>
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
                                    <x-primary-button
                                        x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'edit_contactForm_{{ $contact->id }}')"
                                    >
                                        {{ __('Edit') }}
                                    </x-primary-button>

                                    <x-modal name="edit_contactForm_{{ $contact->id }}" :show="$errors->{'contactUpdate_' . $contact->id}->isNotEmpty()">
                                        <form method="post" action="{{ route('contacts.update', ['contact_id' => $contact->id]) }}" enctype="multipart/form-data" class="p-6">
                                            @csrf
                                            @method('patch')

                                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                {{ __('Update contact') }}
                                            </h2>

                                            <div class="mt-6">
                                                <x-input-label for="contact_number" value="{{ __('Contact Number') }}" class="sr-only" />

                                                <x-text-input
                                                    id="contact_number"
                                                    name="contact_number"
                                                    value="{{ $contact->number }}"
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                    placeholder="{{ __('Contact Number') }}"
                                                    :is_invalid="$errors->{'contactUpdate_' . $contact->id}->has('contact_number')"
                                                />

                                                <x-input-error :messages="$errors->{'contactUpdate_' . $contact->id}->get('contact_number')" class="mt-2" />
                                            </div>

                                            <div class="mt-6">
                                                <x-input-label for="contact_name" value="{{ __('Contact Name') }}" class="sr-only" />

                                                <x-text-input
                                                    id="contact_name"
                                                    name="contact_name"
                                                    value="{{ $contact->name }}"
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                    placeholder="{{ __('Contact Name') }}"
                                                    :is_invalid="$errors->{'contactUpdate_' . $contact->id}->has('contact_name')"
                                                />

                                                <x-input-error :messages="$errors->{'contactUpdate_' . $contact->id}->get('contact_name')" class="mt-2" />
                                            </div>

                                            <div class="mt-6">
                                                <p>
                                                    Uploaded file:
                                                    @if(!empty($contact->file_path))
                                                        <a href="{{asset('storage/'.$contact->file_path)}}">
                                                            {{ $contact->file_path }}
                                                        </a>
                                                    @else
                                                        None
                                                    @endif
                                                </p>
                                                <x-input-label for="fileAttachment" value="{{ __('Contact Name') }}" class="sr-only" />

                                                <x-file-upload
                                                    id="fileAttachment"
                                                    name="fileAttachment"
                                                    type="file"
                                                    class="mt-1 block w-full"
                                                    placeholder="{{ __('File attachment') }}"
                                                    :is_invalid="$errors->{'contactUpdate_' . $contact->id}->has('fileAttachment')"
                                                />

                                                <x-input-error :messages="$errors->{'contactUpdate_' . $contact->id}->get('fileAttachment')" class="mt-2" />
                                            </div>

                                            <div class="mt-6 flex justify-end">
                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                    {{ __('Cancel') }}
                                                </x-secondary-button>

                                                <x-primary-button class="ms-3">
                                                    {{ __('Save') }}
                                                </x-primary-button>
                                            </div>
                                        </form>
                                    </x-modal>

                                    
                                    <x-danger-button
                                        x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'delete_contactForm_{{ $contact->id }}')"
                                    >
                                        {{ __('Delete') }}
                                    </x-danger-button>

                                    <x-modal name="delete_contactForm_{{ $contact->id }}" :show="$errors->{'contactUpdate_' . $contact->id}->isNotEmpty()">
                                        <form method="post" action="{{ route('contacts.destroy', ['contact_id' => $contact->id]) }}" class="p-6">
                                            @csrf
                                            @method('delete')

                                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                {{ __('Delete contact') }}
                                            </h2>

                                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                {{ __('Are you sure you want to delete your this contact?') }}
                                            </p>

                                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                Contact number: {{ $contact->number }}
                                            </p>

                                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                Contact name: {{ $contact->name }}
                                            </p>

                                            <div class="mt-6 flex justify-end">
                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                    {{ __('Cancel') }}
                                                </x-secondary-button>

                                                <x-danger-button class="ms-3">
                                                    {{ __('Delete Contact') }}
                                                </x-danger-button>
                                            </div>
                                        </form>
                                    </x-modal>
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