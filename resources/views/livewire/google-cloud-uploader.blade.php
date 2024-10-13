<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="uploadFile">
        <input type="file" wire:model="file">

        @error('file') <span class="error">{{ $message }}</span> @enderror

        <button type="submit" class="btn btn-primary">Upload naar Google Cloud</button>
    </form>
</div>
