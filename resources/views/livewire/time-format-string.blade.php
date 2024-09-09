{{--<div>--}}
{{--    <div x-data="{--}}
{{--    carbonDate: {{ json_encode($date) }},--}}
{{--    formattedTime: '',--}}
{{--    init() {--}}
{{--        const date = new Date(this.carbonDate);--}}
{{--        this.formattedTime = date.toLocaleString(undefined, {--}}
{{--            hour: 'numeric',--}}
{{--            minute: '2-digit',--}}
{{--            hour12: true // Ensures 12-hour format with AM/PM--}}
{{--        });--}}
{{--    }--}}
{{--}">--}}
{{--        <p><span x-text="formattedTime"></span></p>--}}
{{--    </div>--}}
{{--</div>--}}

<span x-text="new Date('{{ $date }}').toLocaleString(undefined, {
        hour: 'numeric',
        minute: '2-digit',
        hour12: true // Ensures 12-hour format with AM/PM
})"></span>
