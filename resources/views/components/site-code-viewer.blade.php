<div>
    <div class="space-y-4">
        @if($reportEnabled)
            <div>
                <label for="report-anchor" class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                        {{ __('feedbackie-core::labels.code_viewer.report_anchor_label') }}
                    </span>
                </label>
                <x-filament::input.wrapper>
                    <x-filament::input
                        type="text"
                        id="report-anchor"
                        wire:model.live="reportAnchor"
                        :placeholder="__('feedbackie-core::labels.code_viewer.report_anchor_placeholder')"
                    />
                </x-filament::input.wrapper>
            </div>
        @endif

        @if($feedbackEnabled)
            <div>
                <label for="feedback-anchor" class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                        {{ __('feedbackie-core::labels.code_viewer.feedback_anchor_label') }}
                    </span>
                </label>
                <x-filament::input.wrapper>
                    <x-filament::input
                        type="text"
                        id="feedback-anchor"
                        wire:model.live="feedbackAnchor"
                        :placeholder="__('feedbackie-core::labels.code_viewer.feedback_anchor_placeholder')"
                    />
                </x-filament::input.wrapper>
            </div>
        @endif

        <div>
            <div class="flex justify-between items-center mb-2">
                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                        {{ __('feedbackie-core::labels.code_viewer.generated_code_label') }}
                    </span>
                </label>
                <x-filament::button
                    size="sm"
                    x-on:click="
                        navigator.clipboard.writeText($wire.generatedCode);
                        new FilamentNotification()
                            .title('{{ __('feedbackie-core::labels.code_viewer.copied') }}')
                            .success()
                            .send();
                    "
                    icon="heroicon-o-clipboard-document"
                >
                    {{ __('feedbackie-core::labels.code_viewer.copy_code') }}
                </x-filament::button>
            </div>
            <x-filament::input.wrapper>
                <textarea disabled rows="15"
                          class="fi-fo-textarea block w-full rounded-lg border-none bg-white px-3 py-1.5 text-base text-gray-950 shadow-sm outline-none ring-1 transition duration-75 placeholder:text-gray-400 focus-visible:ring-2 disabled:bg-gray-50 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:bg-white/5 dark:text-white dark:placeholder:text-gray-500 dark:disabled:bg-transparent dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 ring-gray-950/10 focus-visible:ring-primary-600 dark:ring-white/20 dark:focus-visible:ring-primary-500 dark:disabled:ring-white/10">{{ $this->generatedCode }}</textarea>
            </x-filament::input.wrapper>
        </div>
    </div>
</div>

