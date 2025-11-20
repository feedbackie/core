<script>
    window.feedbackie_settings = window.feedbackie_settings || [];
    window.feedbackie_settings.site_id = "{{$siteId}}";
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
<script src="{{asset("vendor/feedbackie/build/assets/app.js")}}"></script>
