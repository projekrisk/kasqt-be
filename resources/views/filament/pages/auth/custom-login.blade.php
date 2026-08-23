<main class="relative z-10 flex-1 flex flex-col items-center justify-center px-4 w-full h-full pb-10">
    <div class="w-full max-w-md glass rounded-[2rem] p-8 md:p-10 shadow-2xl shadow-emerald-900/20 border border-slate-700 relative z-20">
        
        <div class="text-center mb-8">
            <img src="{{ asset('images/icon.png') }}" alt="Kasqt Logo" class="w-16 h-16 mx-auto rounded-2xl shadow-lg shadow-emerald-900/50 mb-4 object-cover">
            <h2 class="text-3xl font-bold text-white tracking-tight">Masuk Admin</h2>
            <p class="text-slate-400 mt-2 text-sm">Kelola ekosistem Kasqt Anda</p>
        </div>

        <x-filament-panels::form wire:submit="authenticate">
            {{ $this->form }}

            <div class="mt-2">
                <x-filament-panels::form.actions
                    :actions="$this->getCachedFormActions()"
                    :full-width="$this->hasFullWidthFormActions()"
                />
            </div>
        </x-filament-panels::form>
        
    </div>
</main>