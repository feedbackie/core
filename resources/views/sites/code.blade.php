<script>
    window.feedbackie_settings = window.feedbackie_settings || [];
    window.feedbackie_settings.site_id = "{{$siteId}}";
    window.feedbackie_settings.display_powered_by = @php echo $displayPoweredBy ? "true" : "false" @endphp;
@if($reportEnabled)
    window.feedbackie_settings.report_enabled = true;
    window.feedbackie_settings.report_display_message = @php echo $reportMessageEnabled ? "true": "false" @endphp;
    window.feedbackie_settings.report_display_button = @php echo $reportButtonEnabled ? "true": "false" @endphp;
    window.feedbackie_settings.report_message_anchor_selector = "{{$reportMessageAnchorSelector}}";
@else
    window.feedbackie_settings.report_enabled = false;
@endif
@if($feedbackEnabled)
     window.feedbackie_settings.feedback_enabled = true;
     window.feedbackie_settings.feedback_widget_theme = "{{$feedbackWidgetTheme}}";
     window.feedbackie_settings.feedback_sticky_ratio = {{$feedbackStickyRatio}};
     window.feedbackie_settings.feedback_sticky_persent = {{$feedbackStickyPercent}};
     window.feedbackie_settings.feedback_widget_anchor_selector = "{{$feedbackWidgetAnchorSelector}}";
@else
     window.feedbackie_settings.feedback_enabled = false;
@endif
@if($baseUrl !== null)
     window.feedbackie_settings.base_url = "{{$baseUrl}}";
@endif
@if($locale !== null)
     window.feedbackie_settings.locale = "{{$locale}}";
@endif
</script>
<script src="{{asset(config('feedbackie.asset_url'))}}" defer></script>
