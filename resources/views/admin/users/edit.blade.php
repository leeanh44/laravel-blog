<x-layout>
    <x-setting :heading="'Edit User: ' . $user->title">
        <form method="POST" action="/admin/users/{{ $user->id }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <x-form.input name="username" :value="old('username', $user->username)" required />
            <x-form.input name="name" :value="old('name', $user->name)" />
            <x-form.input name="email" :value="old('email', $user->email)" required />

            <x-form.button>Update</x-form.button>
        </form>
    </x-setting>
</x-layout>
