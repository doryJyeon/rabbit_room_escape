<article class="w-100 my-5">
  <div id="calendar1" class="mw-600 d-block m-auto"></div>
</article>
<hr class="border-3 mt-0 border-primary bg-primary opacity-50" />

<!-- fullcalendar - 달력 call set-->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="/js/fullCalender.js"></script>
<script>
  getCalendar("calendar1", "/admin/schedule/1?");
</script>