<div style="margin-left: 1rem; float: left">
    <x-filament::input.wrapper
        class="fi-fo-select"
        :attributes="\Filament\Support\prepare_inherited_attributes($this->getExtraAttributeBag())"
    >
        <x-filament::input.select wire:model="siteId" wire:change="siteSelected">
            <option value="">
                {{ $placeholder }}
            </option>

            @foreach ($sites as $id => $site)
                <option value="{{ $id }}">{{ $site }}</option>
            @endforeach
        </x-filament::input.select>
    </x-filament::input.wrapper>
</div>
