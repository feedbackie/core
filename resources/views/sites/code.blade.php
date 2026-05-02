<script>
    window.feedbackie_settings = window.feedbackie_settings || [];
    window.feedbackie_settings.site_id = "{{$siteId}}";
    window.feedbackie_settings.feedback_sticky_ratio = {{$stickyRatio}};
@if($displayPoweredBy)
    window.feedbackie_settings.display_powered_by = true;
@else
    window.feedbackie_settings.display_powered_by = false;
@endif
@if($reportEnabled)
    window.feedbackie_settings.report_enabled = true;
    window.feedbackie_settings.report_anchor_selector = "{{$reportAnchorSelector}}";
@else
     window.feedbackie_settings.report_enabled = false;
@endif
@if($feedbackEnabled)
     window.feedbackie_settings.feedback_enabled = true;
     window.feedbackie_settings.feedback_anchor_selector = "{{$feedbackAnchorSelector}}";
@else
     window.feedbackie_settings.feedback_enabled = false;
@endif
@if($baseUrl !== null)
      window.feedbackie_settings.base_url = "{{$baseUrl}}";
@endif
@if($baseUrl !== null)
      window.feedbackie_settings.locale = "{{$locale}}";
@endif
</script>
<script src="{{asset(config('feedbackie.asset_url'))}}"></script>
