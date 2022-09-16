<x-layout>
    <x-setting heading="Publish New Categories">
        <form method="POST" action="/admin/posts" enctype="multipart/form-data">
            @csrf

            <x-form.input name="name" required />

            <x-form.button>Publish</x-form.button>
        </form>
    </x-setting>
</x-layout>
