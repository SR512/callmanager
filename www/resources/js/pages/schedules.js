"use strict";var ScheduleList=[],SCHEDULE_CATEGORY=["milestone","task"];function ScheduleInfo(){this.id=null,this.calendarId=null,this.title=null,this.body=null,this.isAllday=!1,this.start=null,this.end=null,this.category="",this.dueDateClass="",this.color=null,this.bgColor=null,this.dragBgColor=null,this.borderColor=null,this.customStyle="",this.isFocused=!1,this.isPending=!1,this.isVisible=!0,this.isReadOnly=!1,this.goingDuration=0,this.comingDuration=0,this.recurrenceRule="",this.state="",this.raw={memo:"",hasToOrCc:!1,hasRecurrenceRule:!1,location:null,class:"public",creator:{name:"",avatar:"",company:"",email:"",phone:""}}}function generateTime(e,a,o){var n=moment(a.getTime()),a=moment(o.getTime()),o=a.diff(n,"days");e.isAllday=chance.bool({likelihood:30}),e.isAllday?e.category="allday":chance.bool({likelihood:30})?(e.category=SCHEDULE_CATEGORY[chance.integer({min:0,max:1})],e.category===SCHEDULE_CATEGORY[1]&&(e.dueDateClass="morning")):e.category="time",n.add(chance.integer({min:0,max:o}),"days"),n.hours(chance.integer({min:0,max:23})),n.minutes(chance.bool()?0:30),e.start=n.toDate(),a=moment(n),e.isAllday&&a.add(chance.integer({min:0,max:3}),"days"),e.end=a.add(chance.integer({min:1,max:4}),"hour").toDate(),!e.isAllday&&chance.bool({likelihood:20})&&(e.goingDuration=chance.integer({min:30,max:120}),e.comingDuration=chance.integer({min:30,max:120}),chance.bool({likelihood:50})&&(e.end=e.start))}function generateNames(){for(var e=[],a=0,o=chance.integer({min:1,max:10});a<o;a+=1)e.push(chance.name());return e}function generateRandomSchedule(e,a,o){var n=new ScheduleInfo;n.id=chance.guid(),n.calendarId=e.id,n.title=chance.sentence({words:3}),n.body=chance.bool({likelihood:20})?chance.sentence({words:10}):"",n.isReadOnly=chance.bool({likelihood:20}),generateTime(n,a,o),n.isPrivate=chance.bool({likelihood:10}),n.location=chance.address(),n.attendees=chance.bool({likelihood:70})?generateNames():[],n.recurrenceRule=chance.bool({likelihood:20})?"repeated events":"",n.state=chance.bool({likelihood:20})?"Free":"Busy",n.color=e.color,n.bgColor=e.bgColor,n.dragBgColor=e.dragBgColor,n.borderColor=e.borderColor,"milestone"===n.category&&(n.color=n.bgColor,n.bgColor="transparent",n.dragBgColor="transparent",n.borderColor="transparent"),n.raw.memo=chance.sentence(),n.raw.creator.name=chance.name(),n.raw.creator.avatar=chance.avatar(),n.raw.creator.company=chance.company(),n.raw.creator.email=chance.email(),n.raw.creator.phone=chance.phone(),chance.bool({likelihood:20})&&(e=chance.minute(),n.goingDuration=e,n.comingDuration=e),ScheduleList.push(n)}function generateSchedule(n,i,t){ScheduleList=[],CalendarList.forEach(function(e){var a=0,o=10;for("month"===n?o=3:"day"===n&&(o=4);a<o;a+=1)generateRandomSchedule(e,i,t)})}