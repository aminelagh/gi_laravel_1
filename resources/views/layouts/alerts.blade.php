
<!-- notify -->
<script src="public/notify/bootstrap-notify.min.js" type="text/javascript"></script>

<script>

{{-- alert success --}}
@if(session('alert_success'))

$.notify({
  message: "{!! session('alert_success') !!}",
},{
  position: null,
  type: "success",
  allow_dismiss: true,
  newest_on_top: true,
  delay: 0,
  placement: {from: "top",align: "center"},
  url_target: '_blank',
  mouse_over: null,
  icon_type: 'class',
});

@elseif(isset($alert_success))

$.notify({
  message: "{!! $alert_success !!}",
},{
  position: null,
  type: "success",
  allow_dismiss: true,
  newest_on_top: true,
  delay: 0,
  placement: {from: "top",align: "center"},
  url_target: '_blank',
  mouse_over: null,
  icon_type: 'class',
});

@endif
{{-- /.alert success --}}
{{-- ********************************************************************** --}}
{{-- alert info --}}
@if(session('alert_info'))

$.notify({
  message: "{!! session('alert_info') !!}",
},{
  position: null,
  type: "info",
  allow_dismiss: true,
  newest_on_top: true,
  delay: 0,
  placement: {from: "top",align: "center"},
  url_target: '_blank',
  mouse_over: null,
  icon_type: 'class',
});

@elseif(isset($alert_info))

$.notify({
  message: "{!! $alert_info !!}",
},{
  position: null,
  type: "info",
  allow_dismiss: true,
  newest_on_top: true,
  delay: 0,
  placement: {from: "top",align: "center"},
  url_target: '_blank',
  mouse_over: null,
  icon_type: 'class',
});

@endif
{{-- /.alert info --}}
{{-- ********************************************************************** --}}
{{-- alert danger --}}
@if(session('alert_danger'))

$.notify({
  message: "{!! session('alert_danger') !!}",
},{
  position: null,
  type: "danger",
  allow_dismiss: true,
  newest_on_top: true,
  delay: 0,
  placement: {from: "top",align: "center"},
  url_target: '_blank',
  mouse_over: null,
  icon_type: 'class',
});

@elseif(isset($alert_danger))

$.notify({
  message: "{!! $alert_danger !!}",
},{
  position: null,
  type: "danger",
  allow_dismiss: true,
  newest_on_top: true,
  delay: 0,
  placement: {from: "top",align: "center"},
  url_target: '_blank',
  mouse_over: null,
  icon_type: 'class',
});

@endif
{{-- /.alert danger --}}
{{-- ********************************************************************** --}}
{{-- alert Warning --}}
@if(session('alert_warning'))

$.notify({
  message: "{!! session('alert_warning') !!}",
},{
  position: null,
  type: "warning",
  allow_dismiss: true,
  newest_on_top: true,
  delay: 0,
  placement: {from: "top",align: "center"},
  url_target: '_blank',
  mouse_over: null,
  icon_type: 'class',
});

@elseif(isset($alert_warning))

$.notify({
  message: "{!! $alert_warning !!}",
},{
  position: null,
  type: "warning",
  allow_dismiss: true,
  newest_on_top: true,
  delay: 0,
  placement: {from: "top",align: "center"},
  url_target: '_blank',
  mouse_over: null,
  icon_type: 'class',
});

@endif
{{-- /.alert warning --}}


</script>
