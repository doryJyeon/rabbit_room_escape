/**
 * full 달력 출력 & 일자 선택 페이지 이동
 * 사용하려면 해당 내용 전부 써줘야함
 * <div id="calendarId"></div>
 * <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
 * <script src="/js/calendar.js"></script>
 * 
 * <script>
 * initCalendar('calendarId', '/예약추가');
 * </script>
 * @param {string} elementCalendarId,
 * @param {string} moveUrl
 */
function getCalendar(calendarId, baseUrl) {
  document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById(calendarId);

    if (!calendarEl) return; // 캘린더 요소 없으면 종료, 한번 더 체크

    let calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      initialDate: null,
      locale: "ko",
      headerToolbar: {
        start: "prev",
        center: "title",
        end: "next"
      },
      dayCellClassNames: function (arg) {
        let day = arg.date.getDay();
        if (day === 0) {  // 일요일
          return 'calendar-days text-danger';
        }
        if (day === 6) {  // 토요일
          return 'calendar-days text-blue';
        }
        return 'calendar-days';
      },
      dayCellContent: function (arg) { 
        return { html: arg.date.getDate() };  // 숫자만 출력
      },
      dateClick: function(info) {
        let clickedDate = info.dateStr; // yyyy-mm-dd
        window.location.href = baseUrl + '&date=' + clickedDate;
      }
    });

    calendar.render();
  });
}