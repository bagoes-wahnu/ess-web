/*!
 * Datepicker for Bootstrap v1.9.0 (https://github.com/uxsolutions/bootstrap-datepicker)
 *
 * Licensed under the Apache License v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 */

!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof exports?require("jquery"):jQuery)}(function(a,b){function c(){return new Date(Date.UTC.apply(Date,arguments))}function d(){var a=new Date;return c(a.getFullYear(),a.getMonth(),a.getDate())}function e(a,b){return a.getUTCFullYear()===b.getUTCFullYear()&&a.getUTCMonth()===b.getUTCMonth()&&a.getUTCDate()===b.getUTCDate()}function f(c,d){return function(){return d!==b&&a.fn.datepicker.deprecated(d),this[c].apply(this,arguments)}}function g(a){return a&&!isNaN(a.getTime())}function h(b,c){function d(a,b){return b.toLowerCase()}var e,f=a(b).data(),g={},h=new RegExp("^"+c.toLowerCase()+"([A-Z])");c=new RegExp("^"+c.toLowerCase());for(var i in f)c.test(i)&&(e=i.replace(h,d),g[e]=f[i]);return g}function i(b){var c={};if(q[b]||(b=b.split("-")[0],q[b])){var d=q[b];return a.each(p,function(a,b){b in d&&(c[b]=d[b])}),c}}var j=function(){var b={get:function(a){return this.slice(a)[0]},contains:function(a){for(var b=a&&a.valueOf(),c=0,d=this.length;c<d;c++)if(0<=this[c].valueOf()-b&&this[c].valueOf()-b<864e5)return c;return-1},remove:function(a){this.splice(a,1)},replace:function(b){b&&(a.isArray(b)||(b=[b]),this.clear(),this.push.apply(this,b))},clear:function(){this.length=0},copy:function(){var a=new j;return a.replace(this),a}};return function(){var c=[];return c.push.apply(c,arguments),a.extend(c,b),c}}(),k=function(b,c){a.data(b,"datepicker",this),this._events=[],this._secondaryEvents=[],this._process_options(c),this.dates=new j,this.viewDate=this.o.defaultViewDate,this.focusDate=null,this.element=a(b),this.isInput=this.element.is("input"),this.inputField=this.isInput?this.element:this.element.find("input"),this.component=!!this.element.hasClass("date")&&this.element.find(".add-on, .input-group-addon, .input-group-append, .input-group-prepend, .btn"),this.component&&0===this.component.length&&(this.component=!1),this.isInline=!this.component&&this.element.is("div"),this.picker=a(r.template),this._check_template(this.o.templates.leftArrow)&&this.picker.find(".prev").html(this.o.templates.leftArrow),this._check_template(this.o.templates.rightArrow)&&this.picker.find(".next").html(this.o.templates.rightArrow),this._buildEvents(),this._attachEvents(),this.isInline?this.picker.addClass("datepicker-inline").appendTo(this.element):this.picker.addClass("datepicker-dropdown dropdown-menu"),this.o.rtl&&this.picker.addClass("datepicker-rtl"),this.o.calendarWeeks&&this.picker.find(".datepicker-days .datepicker-switch, thead .datepicker-title, tfoot .today, tfoot .clear").attr("colspan",function(a,b){return Number(b)+1}),this._process_options({startDate:this._o.startDate,endDate:this._o.endDate,daysOfWeekDisabled:this.o.daysOfWeekDisabled,daysOfWeekHighlighted:this.o.daysOfWeekHighlighted,datesDisabled:this.o.datesDisabled}),this._allow_update=!1,this.setViewMode(this.o.startView),this._allow_update=!0,this.fillDow(),this.fillMonths(),this.update(),this.isInline&&this.show()};k.prototype={constructor:k,_resolveViewName:function(b){return a.each(r.viewModes,function(c,d){if(b===c||-1!==a.inArray(b,d.names))return b=c,!1}),b},_resolveDaysOfWeek:function(b){return a.isArray(b)||(b=b.split(/[,\s]*/)),a.map(b,Number)},_check_template:function(c){try{if(c===b||""===c)return!1;if((c.match(/[<>]/g)||[]).length<=0)return!0;return a(c).length>0}catch(a){return!1}},_process_options:function(b){this._o=a.extend({},this._o,b);var e=this.o=a.extend({},this._o),f=e.language;q[f]||(f=f.split("-")[0],q[f]||(f=o.language)),e.language=f,e.startView=this._resolveViewName(e.startView),e.minViewMode=this._resolveViewName(e.minViewMode),e.maxViewMode=this._resolveViewName(e.maxViewMode),e.startView=Math.max(this.o.minViewMode,Math.min(this.o.maxViewMode,e.startView)),!0!==e.multidate&&(e.multidate=Number(e.multidate)||!1,!1!==e.multidate&&(e.multidate=Math.max(0,e.multidate))),e.multidateSeparator=String(e.multidateSeparator),e.weekStart%=7,e.weekEnd=(e.weekStart+6)%7;var g=r.parseFormat(e.format);e.startDate!==-1/0&&(e.startDate?e.startDate instanceof Date?e.startDate=this._local_to_utc(this._zero_time(e.startDate)):e.startDate=r.parseDate(e.startDate,g,e.language,e.assumeNearbyYear):e.startDate=-1/0),e.endDate!==1/0&&(e.endDate?e.endDate instanceof Date?e.endDate=this._local_to_utc(this._zero_time(e.endDate)):e.endDate=r.parseDate(e.endDate,g,e.language,e.assumeNearbyYear):e.endDate=1/0),e.daysOfWeekDisabled=this._resolveDaysOfWeek(e.daysOfWeekDisabled||[]),e.daysOfWeekHighlighted=this._resolveDaysOfWeek(e.daysOfWeekHighlighted||[]),e.datesDisabled=e.datesDisabled||[],a.isArray(e.datesDisabled)||(e.datesDisabled=e.datesDisabled.split(",")),e.datesDisabled=a.map(e.datesDisabled,function(a){return r.parseDate(a,g,e.language,e.assumeNearbyYear)});var h=String(e.orientation).toLowerCase().split(/\s+/g),i=e.orientation.toLowerCase();if(h=a.grep(h,function(a){return/^auto|left|right|top|bottom$/.test(a)}),e.orientation={x:"auto",y:"auto"},i&&"auto"!==i)if(1===h.length)switch(h[0]){case"top":case"bottom":e.orientation.y=h[0];break;case"left":case"right":e.orientation.x=h[0]}else i=a.grep(h,function(a){return/^left|right$/.test(a)}),e.orientation.x=i[0]||"auto",i=a.grep(h,function(a){return/^top|bottom$/.test(a)}),e.orientation.y=i[0]||"auto";else;if(e.defaultViewDate instanceof Date||"string"==typeof e.defaultViewDate)e.defaultViewDate=r.parseDate(e.defaultViewDate,g,e.language,e.assumeNearbyYear);else if(e.defaultViewDate){var j=e.defaultViewDate.year||(new Date).getFullYear(),k=e.defaultViewDate.month||0,l=e.defaultViewDate.day||1;e.defaultViewDate=c(j,k,l)}else e.defaultViewDate=d()},_applyEvents:function(a){for(var c,d,e,f=0;f<a.length;f++)c=a[f][0],2===a[f].length?(d=b,e=a[f][1]):3===a[f].length&&(d=a[f][1],e=a[f][2]),c.on(e,d)},_unapplyEvents:function(a){for(var c,d,e,f=0;f<a.length;f++)c=a[f][0],2===a[f].length?(e=b,d=a[f][1]):3===a[f].length&&(e=a[f][1],d=a[f][2]),c.off(d,e)},_buildEvents:function(){var b={keyup:a.proxy(function(b){-1===a.inArray(b.keyCode,[27,37,39,38,40,32,13,9])&&this.update()},this),keydown:a.proxy(this.keydown,this),paste:a.proxy(this.paste,this)};!0===this.o.showOnFocus&&(b.focus=a.proxy(this.show,this)),this.isInput?this._events=[[this.element,b]]:this.component&&this.inputField.length?this._events=[[this.inputField,b],[this.component,{click:a.proxy(this.show,this)}]]:this._events=[[this.element,{click:a.proxy(this.show,this),keydown:a.proxy(this.keydown,this)}]],this._events.push([this.element,"*",{blur:a.proxy(function(a){this._focused_from=a.target},this)}],[this.element,{blur:a.proxy(function(a){this._focused_from=a.target},this)}]),this.o.immediateUpdates&&this._events.push([this.element,{"changeYear changeMonth":a.proxy(function(a){this.update(a.date)},this)}]),this._secondaryEvents=[[this.picker,{click:a.proxy(this.click,this)}],[this.picker,".prev, .next",{click:a.proxy(this.navArrowsClick,this)}],[this.picker,".day:not(.disabled)",{click:a.proxy(this.dayCellClick,this)}],[a(window),{resize:a.proxy(this.place,this)}],[a(document),{"mousedown touchstart":a.proxy(function(a){this.element.is(a.target)||this.element.find(a.target).length||this.picker.is(a.target)||this.picker.find(a.target).length||this.isInline||this.hide()},this)}]]},_attachEvents:function(){this._detachEvents(),this._applyEvents(this._events)},_detachEvents:function(){this._unapplyEvents(this._events)},_attachSecondaryEvents:function(){this._detachSecondaryEvents(),this._applyEvents(this._secondaryEvents)},_detachSecondaryEvents:function(){this._unapplyEvents(this._secondaryEvents)},_trigger:function(b,c){var d=c||this.dates.get(-1),e=this._utc_to_local(d);this.element.trigger({type:b,date:e,viewMode:this.viewMode,dates:a.map(this.dates,this._utc_to_local),format:a.proxy(function(a,b){0===arguments.length?(a=this.dates.length-1,b=this.o.format):"string"==typeof a&&(b=a,a=this.dates.length-1),b=b||this.o.format;var c=this.dates.get(a);return r.formatDate(c,b,this.o.language)},this)})},show:function(){if(!(this.inputField.is(":disabled")||this.inputField.prop("readonly")&&!1===this.o.enableOnReadonly))return this.isInline||this.picker.appendTo(this.o.container),this.place(),this.picker.show(),this._attachSecondaryEvents(),this._trigger("show"),(window.navigator.msMaxTouchPoints||"ontouchstart"in document)&&this.o.disableTouchKeyboard&&a(this.element).blur(),this},hide:function(){return this.isInline||!this.picker.is(":visible")?this:(this.focusDate=null,this.picker.hide().detach(),this._detachSecondaryEvents(),this.setViewMode(this.o.startView),this.o.forceParse&&this.inputField.val()&&this.setValue(),this._trigger("hide"),this)},destroy:function(){return this.hide(),this._detachEvents(),this._detachSecondaryEvents(),this.picker.remove(),delete this.element.data().datepicker,this.isInput||delete this.element.data().date,this},paste:function(b){var c;if(b.originalEvent.clipboardData&&b.originalEvent.clipboardData.types&&-1!==a.inArray("text/plain",b.originalEvent.clipboardData.types))c=b.originalEvent.clipboardData.getData("text/plain");else{if(!window.clipboardData)return;c=window.clipboardData.getData("Text")}this.setDate(c),this.update(),b.preventDefault()},_utc_to_local:function(a){if(!a)return a;var b=new Date(a.getTime()+6e4*a.getTimezoneOffset());return b.getTimezoneOffset()!==a.getTimezoneOffset()&&(b=new Date(a.getTime()+6e4*b.getTimezoneOffset())),b},_local_to_utc:function(a){return a&&new Date(a.getTime()-6e4*a.getTimezoneOffset())},_zero_time:function(a){return a&&new Date(a.getFullYear(),a.getMonth(),a.getDate())},_zero_utc_time:function(a){return a&&c(a.getUTCFullYear(),a.getUTCMonth(),a.getUTCDate())},getDates:function(){return a.map(this.dates,this._utc_to_local)},getUTCDates:function(){return a.map(this.dates,function(a){return new Date(a)})},getDate:function(){return this._utc_to_local(this.getUTCDate())},getUTCDate:function(){var a=this.dates.get(-1);return a!==b?new Date(a):null},clearDates:function(){this.inputField.val(""),this.update(),this._trigger("changeDate"),this.o.autoclose&&this.hide()},setDates:function(){var b=a.isArray(arguments[0])?arguments[0]:arguments;return this.update.apply(this,b),this._trigger("changeDate"),this.setValue(),this},setUTCDates:function(){var b=a.isArray(arguments[0])?arguments[0]:arguments;return this.setDates.apply(this,a.map(b,this._utc_to_local)),this},setDate:f("setDates"),setUTCDate:f("setUTCDates"),remove:f("destroy","Method `remove` is deprecated and will be removed in version 2.0. Use `destroy` instead"),setValue:function(){var a=this.getFormattedDate();return this.inputField.val(a),this},getFormattedDate:function(c){c===b&&(c=this.o.format);var d=this.o.language;return a.map(this.dates,function(a){return r.formatDate(a,c,d)}).join(this.o.multidateSeparator)},getStartDate:function(){return this.o.startDate},setStartDate:function(a){return this._process_options({startDate:a}),this.update(),this.updateNavArrows(),this},getEndDate:function(){return this.o.endDate},setEndDate:function(a){return this._process_options({endDate:a}),this.update(),this.updateNavArrows(),this},setDaysOfWeekDisabled:function(a){return this._process_options({daysOfWeekDisabled:a}),this.update(),this},setDaysOfWeekHighlighted:function(a){return this._process_options({daysOfWeekHighlighted:a}),this.update(),this},setDatesDisabled:function(a){return this._process_options({datesDisabled:a}),this.update(),this},place:function(){if(this.isInline)return this;var b=this.picker.outerWidth(),c=this.picker.outerHeight(),d=a(this.o.container),e=d.width(),f="body"===this.o.container?a(document).scrollTop():d.scrollTop(),g=d.offset(),h=[0];this.element.parents().each(function(){var b=a(this).css("z-index");"auto"!==b&&0!==Number(b)&&h.push(Number(b))});var i=Math.max.apply(Math,h)+this.o.zIndexOffset,j=this.component?this.component.parent().offset():this.element.offset(),k=this.component?this.component.outerHeight(!0):this.element.outerHeight(!1),l=this.component?this.component.outerWidth(!0):this.element.outerWidth(!1),m=j.left-g.left,n=j.top-g.top;"body"!==this.o.container&&(n+=f),this.picker.removeClass("datepicker-orient-top datepicker-orient-bottom datepicker-orient-right datepicker-orient-left"),"auto"!==this.o.orientation.x?(this.picker.addClass("datepicker-orient-"+this.o.orientation.x),"right"===this.o.orientation.x&&(m-=b-l)):j.left<0?(this.picker.addClass("datepicker-orient-left"),m-=j.left-10):m+b>e?(this.picker.addClass("datepicker-orient-right"),m+=l-b):this.o.rtl?this.picker.addClass("datepicker-orient-right"):this.picker.addClass("datepicker-orient-left");var o,p=this.o.orientation.y;if("auto"===p&&(o=-f+n-c,p=o<0?"bottom":"top"),this.picker.addClass("datepicker-orient-"+p),"top"===p?n-=c+parseInt(this.picker.css("padding-top")):n+=k,this.o.rtl){var q=e-(m+l);this.picker.css({top:n,right:q,zIndex:i})}else this.picker.css({top:n,left:m,zIndex:i});return this},_allow_update:!0,update:function(){if(!this._allow_update)return this;var b=this.dates.copy(),c=[],d=!1;return arguments.length?(a.each(arguments,a.proxy(function(a,b){b instanceof Date&&(b=this._local_to_utc(b)),c.push(b)},this)),d=!0):(c=this.isInput?this.element.val():this.element.data("date")||this.inputField.val(),c=c&&this.o.multidate?c.split(this.o.multidateSeparator):[c],delete this.element.data().date),c=a.map(c,a.proxy(function(a){return r.parseDate(a,this.o.format,this.o.language,this.o.assumeNearbyYear)},this)),c=a.grep(c,a.proxy(function(a){return!this.dateWithinRange(a)||!a},this),!0),this.dates.replace(c),this.o.updateViewDate&&(this.dates.length?this.viewDate=new Date(this.dates.get(-1)):this.viewDate<this.o.startDate?this.viewDate=new Date(this.o.startDate):this.viewDate>this.o.endDate?this.viewDate=new Date(this.o.endDate):this.viewDate=this.o.defaultViewDate),d?(this.setValue(),this.element.change()):this.dates.length&&String(b)!==String(this.dates)&&d&&(this._trigger("changeDate"),this.element.change()),!this.dates.length&&b.length&&(this._trigger("clearDate"),this.element.change()),this.fill(),this},fillDow:function(){if(this.o.showWeekDays){var b=this.o.weekStart,c="<tr>";for(this.o.calendarWeeks&&(c+='<th class="cw">&#160;</th>');b<this.o.weekStart+7;)c+='<th class="dow',-1!==a.inArray(b,this.o.daysOfWeekDisabled)&&(c+=" disabled"),c+='">'+q[this.o.language].daysMin[b++%7]+"</th>";c+="</tr>",this.picker.find(".datepicker-days thead").append(c)}},fillMonths:function(){for(var a,b=this._utc_to_local(this.viewDate),c="",d=0;d<12;d++)a=b&&b.getMonth()===d?" focused":"",c+='<span class="month'+a+'">'+q[this.o.language].monthsShort[d]+"</span>";this.picker.find(".datepicker-months td").html(c)},setRange:function(b){b&&b.length?this.range=a.map(b,function(a){return a.valueOf()}):delete this.range,this.fill()},getClassNames:function(b){var c=[],f=this.viewDate.getUTCFullYear(),g=this.viewDate.getUTCMonth(),h=d();return b.getUTCFullYear()<f||b.getUTCFullYear()===f&&b.getUTCMonth()<g?c.push("old"):(b.getUTCFullYear()>f||b.getUTCFullYear()===f&&b.getUTCMonth()>g)&&c.push("new"),this.focusDate&&b.valueOf()===this.focusDate.valueOf()&&c.push("focused"),this.o.todayHighlight&&e(b,h)&&c.push("today"),-1!==this.dates.contains(b)&&c.push("active"),this.dateWithinRange(b)||c.push("disabled"),this.dateIsDisabled(b)&&c.push("disabled","disabled-date"),-1!==a.inArray(b.getUTCDay(),this.o.daysOfWeekHighlighted)&&c.push("highlighted"),this.range&&(b>this.range[0]&&b<this.range[this.range.length-1]&&c.push("range"),-1!==a.inArray(b.valueOf(),this.range)&&c.push("selected"),b.valueOf()===this.range[0]&&c.push("range-start"),b.valueOf()===this.range[this.range.length-1]&&c.push("range-end")),c},_fill_yearsView:function(c,d,e,f,g,h,i){for(var j,k,l,m="",n=e/10,o=this.picker.find(c),p=Math.floor(f/e)*e,q=p+9*n,r=Math.floor(this.viewDate.getFullYear()/n)*n,s=a.map(this.dates,function(a){return Math.floor(a.getUTCFullYear()/n)*n}),t=p-n;t<=q+n;t+=n)j=[d],k=null,t===p-n?j.push("old"):t===q+n&&j.push("new"),-1!==a.inArray(t,s)&&j.push("active"),(t<g||t>h)&&j.push("disabled"),t===r&&j.push("focused"),i!==a.noop&&(l=i(new Date(t,0,1)),l===b?l={}:"boolean"==typeof l?l={enabled:l}:"string"==typeof l&&(l={classes:l}),!1===l.enabled&&j.push("disabled"),l.classes&&(j=j.concat(l.classes.split(/\s+/))),l.tooltip&&(k=l.tooltip)),m+='<span class="'+j.join(" ")+'"'+(k?' title="'+k+'"':"")+">"+t+"</span>";o.find(".datepicker-switch").text(p+"-"+q),o.find("td").html(m)},fill:function(){var e,f,g=new Date(this.viewDate),h=g.getUTCFullYear(),i=g.getUTCMonth(),j=this.o.startDate!==-1/0?this.o.startDate.getUTCFullYear():-1/0,k=this.o.startDate!==-1/0?this.o.startDate.getUTCMonth():-1/0,l=this.o.endDate!==1/0?this.o.endDate.getUTCFullYear():1/0,m=this.o.endDate!==1/0?this.o.endDate.getUTCMonth():1/0,n=q[this.o.language].today||q.en.today||"",o=q[this.o.language].clear||q.en.clear||"",p=q[this.o.language].titleFormat||q.en.titleFormat,s=d(),t=(!0===this.o.todayBtn||"linked"===this.o.todayBtn)&&s>=this.o.startDate&&s<=this.o.endDate&&!this.weekOfDateIsDisabled(s);if(!isNaN(h)&&!isNaN(i)){this.picker.find(".datepicker-days .datepicker-switch").text(r.formatDate(g,p,this.o.language)),this.picker.find("tfoot .today").text(n).css("display",t?"table-cell":"none"),this.picker.find("tfoot .clear").text(o).css("display",!0===this.o.clearBtn?"table-cell":"none"),this.picker.find("thead .datepicker-title").text(this.o.title).css("display","string"==typeof this.o.title&&""!==this.o.title?"table-cell":"none"),this.updateNavArrows(),this.fillMonths();var u=c(h,i,0),v=u.getUTCDate();u.setUTCDate(v-(u.getUTCDay()-this.o.weekStart+7)%7);var w=new Date(u);u.getUTCFullYear()<100&&w.setUTCFullYear(u.getUTCFullYear()),w.setUTCDate(w.getUTCDate()+42),w=w.valueOf();for(var x,y,z=[];u.valueOf()<w;){if((x=u.getUTCDay())===this.o.weekStart&&(z.push("<tr>"),this.o.calendarWeeks)){var A=new Date(+u+(this.o.weekStart-x-7)%7*864e5),B=new Date(Number(A)+(11-A.getUTCDay())%7*864e5),C=new Date(Number(C=c(B.getUTCFullYear(),0,1))+(11-C.getUTCDay())%7*864e5),D=(B-C)/864e5/7+1;z.push('<td class="cw">'+D+"</td>")}y=this.getClassNames(u),y.push("day");var E=u.getUTCDate();this.o.beforeShowDay!==a.noop&&(f=this.o.beforeShowDay(this._utc_to_local(u)),f===b?f={}:"boolean"==typeof f?f={enabled:f}:"string"==typeof f&&(f={classes:f}),!1===f.enabled&&y.push("disabled"),f.classes&&(y=y.concat(f.classes.split(/\s+/))),f.tooltip&&(e=f.tooltip),f.content&&(E=f.content)),y=a.isFunction(a.uniqueSort)?a.uniqueSort(y):a.unique(y),z.push('<td class="'+y.join(" ")+'"'+(e?' title="'+e+'"':"")+' data-date="'+u.getTime().toString()+'">'+E+"</td>"),e=null,x===this.o.weekEnd&&z.push("</tr>"),u.setUTCDate(u.getUTCDate()+1)}this.picker.find(".datepicker-days tbody").html(z.join(""));var F=q[this.o.language].monthsTitle||q.en.monthsTitle||"Months",G=this.picker.find(".datepicker-months").find(".datepicker-switch").text(this.o.maxViewMode<2?F:h).end().find("tbody span").removeClass("active");if(a.each(this.dates,function(a,b){b.getUTCFullYear()===h&&G.eq(b.getUTCMonth()).addClass("active")}),(h<j||h>l)&&G.addClass("disabled"),h===j&&G.slice(0,k).addClass("disabled"),h===l&&G.slice(m+1).addClass("disabled"),this.o.beforeShowMonth!==a.noop){var H=this;a.each(G,function(c,d){var e=new Date(h,c,1),f=H.o.beforeShowMonth(e);f===b?f={}:"boolean"==typeof f?f={enabled:f}:"string"==typeof f&&(f={classes:f}),!1!==f.enabled||a(d).hasClass("disabled")||a(d).addClass("disabled"),f.classes&&a(d).addClass(f.classes),f.tooltip&&a(d).prop("title",f.tooltip)})}this._fill_yearsView(".datepicker-years","year",10,h,j,l,this.o.beforeShowYear),this._fill_yearsView(".datepicker-decades","decade",100,h,j,l,this.o.beforeShowDecade),this._fill_yearsView(".datepicker-centuries","century",1e3,h,j,l,this.o.beforeShowCentury)}},updateNavArrows:function(){if(this._allow_update){var a,b,c=new Date(this.viewDate),d=c.getUTCFullYear(),e=c.getUTCMonth(),f=this.o.startDate!==-1/0?this.o.startDate.getUTCFullYear():-1/0,g=this.o.startDate!==-1/0?this.o.startDate.getUTCMonth():-1/0,h=this.o.endDate!==1/0?this.o.endDate.getUTCFullYear():1/0,i=this.o.endDate!==1/0?this.o.endDate.getUTCMonth():1/0,j=1;switch(this.viewMode){case 4:j*=10;case 3:j*=10;case 2:j*=10;case 1:a=Math.floor(d/j)*j<=f,b=Math.floor(d/j)*j+j>h;break;case 0:a=d<=f&&e<=g,b=d>=h&&e>=i}this.picker.find(".prev").toggleClass("disabled",a),this.picker.find(".next").toggleClass("disabled",b)}},click:function(b){b.preventDefault(),b.stopPropagation();var e,f,g,h;e=a(b.target),e.hasClass("datepicker-switch")&&this.viewMode!==this.o.maxViewMode&&this.setViewMode(this.viewMode+1),e.hasClass("today")&&!e.hasClass("day")&&(this.setViewMode(0),this._setDate(d(),"linked"===this.o.todayBtn?null:"view")),e.hasClass("clear")&&this.clearDates(),e.hasClass("disabled")||(e.hasClass("month")||e.hasClass("year")||e.hasClass("decade")||e.hasClass("century"))&&(this.viewDate.setUTCDate(1),f=1,1===this.viewMode?(h=e.parent().find("span").index(e),g=this.viewDate.getUTCFullYear(),this.viewDate.setUTCMonth(h)):(h=0,g=Number(e.text()),this.viewDate.setUTCFullYear(g)),this._trigger(r.viewModes[this.viewMode-1].e,this.viewDate),this.viewMode===this.o.minViewMode?this._setDate(c(g,h,f)):(this.setViewMode(this.viewMode-1),this.fill())),this.picker.is(":visible")&&this._focused_from&&this._focused_from.focus(),delete this._focused_from},dayCellClick:function(b){var c=a(b.currentTarget),d=c.data("date"),e=new Date(d);this.o.updateViewDate&&(e.getUTCFullYear()!==this.viewDate.getUTCFullYear()&&this._trigger("changeYear",this.viewDate),e.getUTCMonth()!==this.viewDate.getUTCMonth()&&this._trigger("changeMonth",this.viewDate)),this._setDate(e)},navArrowsClick:function(b){var c=a(b.currentTarget),d=c.hasClass("prev")?-1:1;0!==this.viewMode&&(d*=12*r.viewModes[this.viewMode].navStep),this.viewDate=this.moveMonth(this.viewDate,d),this._trigger(r.viewModes[this.viewMode].e,this.viewDate),this.fill()},_toggle_multidate:function(a){var b=this.dates.contains(a);if(a||this.dates.clear(),-1!==b?(!0===this.o.multidate||this.o.multidate>1||this.o.toggleActive)&&this.dates.remove(b):!1===this.o.multidate?(this.dates.clear(),this.dates.push(a)):this.dates.push(a),"number"==typeof this.o.multidate)for(;this.dates.length>this.o.multidate;)this.dates.remove(0)},_setDate:function(a,b){b&&"date"!==b||this._toggle_multidate(a&&new Date(a)),(!b&&this.o.updateViewDate||"view"===b)&&(this.viewDate=a&&new Date(a)),this.fill(),this.setValue(),b&&"view"===b||this._trigger("changeDate"),this.inputField.trigger("change"),!this.o.autoclose||b&&"date"!==b||this.hide()},moveDay:function(a,b){var c=new Date(a);return c.setUTCDate(a.getUTCDate()+b),c},moveWeek:function(a,b){return this.moveDay(a,7*b)},moveMonth:function(a,b){if(!g(a))return this.o.defaultViewDate;if(!b)return a;var c,d,e=new Date(a.valueOf()),f=e.getUTCDate(),h=e.getUTCMonth(),i=Math.abs(b);if(b=b>0?1:-1,1===i)d=-1===b?function(){return e.getUTCMonth()===h}:function(){return e.getUTCMonth()!==c},c=h+b,e.setUTCMonth(c),c=(c+12)%12;else{for(var j=0;j<i;j++)e=this.moveMonth(e,b);c=e.getUTCMonth(),e.setUTCDate(f),d=function(){return c!==e.getUTCMonth()}}for(;d();)e.setUTCDate(--f),e.setUTCMonth(c);return e},moveYear:function(a,b){return this.moveMonth(a,12*b)},moveAvailableDate:function(a,b,c){do{if(a=this[c](a,b),!this.dateWithinRange(a))return!1;c="moveDay"}while(this.dateIsDisabled(a));return a},weekOfDateIsDisabled:function(b){return-1!==a.inArray(b.getUTCDay(),this.o.daysOfWeekDisabled)},dateIsDisabled:function(b){return this.weekOfDateIsDisabled(b)||a.grep(this.o.datesDisabled,function(a){return e(b,a)}).length>0},dateWithinRange:function(a){return a>=this.o.startDate&&a<=this.o.endDate},keydown:function(a){if(!this.picker.is(":visible"))return void(40!==a.keyCode&&27!==a.keyCode||(this.show(),a.stopPropagation()));var b,c,d=!1,e=this.focusDate||this.viewDate;switch(a.keyCode){case 27:this.focusDate?(this.focusDate=null,this.viewDate=this.dates.get(-1)||this.viewDate,this.fill()):this.hide(),a.preventDefault(),a.stopPropagation();break;case 37:case 38:case 39:case 40:if(!this.o.keyboardNavigation||7===this.o.daysOfWeekDisabled.length)break;b=37===a.keyCode||38===a.keyCode?-1:1,0===this.viewMode?a.ctrlKey?(c=this.moveAvailableDate(e,b,"moveYear"))&&this._trigger("changeYear",this.viewDate):a.shiftKey?(c=this.moveAvailableDate(e,b,"moveMonth"))&&this._trigger("changeMonth",this.viewDate):37===a.keyCode||39===a.keyCode?c=this.moveAvailableDate(e,b,"moveDay"):this.weekOfDateIsDisabled(e)||(c=this.moveAvailableDate(e,b,"moveWeek")):1===this.viewMode?(38!==a.keyCode&&40!==a.keyCode||(b*=4),c=this.moveAvailableDate(e,b,"moveMonth")):2===this.viewMode&&(38!==a.keyCode&&40!==a.keyCode||(b*=4),c=this.moveAvailableDate(e,b,"moveYear")),c&&(this.focusDate=this.viewDate=c,this.setValue(),this.fill(),a.preventDefault());break;case 13:if(!this.o.forceParse)break;e=this.focusDate||this.dates.get(-1)||this.viewDate,this.o.keyboardNavigation&&(this._toggle_multidate(e),d=!0),this.focusDate=null,this.viewDate=this.dates.get(-1)||this.viewDate,this.setValue(),this.fill(),this.picker.is(":visible")&&(a.preventDefault(),a.stopPropagation(),this.o.autoclose&&this.hide());break;case 9:this.focusDate=null,this.viewDate=this.dates.get(-1)||this.viewDate,this.fill(),this.hide()}d&&(this.dates.length?this._trigger("changeDate"):this._trigger("clearDate"),this.inputField.trigger("change"))},setViewMode:function(a){this.viewMode=a,this.picker.children("div").hide().filter(".datepicker-"+r.viewModes[this.viewMode].clsName).show(),this.updateNavArrows(),this._trigger("changeViewMode",new Date(this.viewDate))}};var l=function(b,c){a.data(b,"datepicker",this),this.element=a(b),this.inputs=a.map(c.inputs,function(a){return a.jquery?a[0]:a}),delete c.inputs,this.keepEmptyValues=c.keepEmptyValues,delete c.keepEmptyValues,n.call(a(this.inputs),c).on("changeDate",a.proxy(this.dateUpdated,this)),this.pickers=a.map(this.inputs,function(b){return a.data(b,"datepicker")}),this.updateDates()};l.prototype={updateDates:function(){this.dates=a.map(this.pickers,function(a){return a.getUTCDate()}),this.updateRanges()},updateRanges:function(){var b=a.map(this.dates,function(a){return a.valueOf()});a.each(this.pickers,function(a,c){c.setRange(b)})},clearDates:function(){a.each(this.pickers,function(a,b){b.clearDates()})},dateUpdated:function(c){if(!this.updating){this.updating=!0;var d=a.data(c.target,"datepicker");if(d!==b){var e=d.getUTCDate(),f=this.keepEmptyValues,g=a.inArray(c.target,this.inputs),h=g-1,i=g+1,j=this.inputs.length;if(-1!==g){if(a.each(this.pickers,function(a,b){b.getUTCDate()||b!==d&&f||b.setUTCDate(e)}),e<this.dates[h])for(;h>=0&&e<this.dates[h];)this.pickers[h--].setUTCDate(e);else if(e>this.dates[i])for(;i<j&&e>this.dates[i];)this.pickers[i++].setUTCDate(e);this.updateDates(),delete this.updating}}}},destroy:function(){a.map(this.pickers,function(a){a.destroy()}),a(this.inputs).off("changeDate",this.dateUpdated),delete this.element.data().datepicker},remove:f("destroy","Method `remove` is deprecated and will be removed in version 2.0. Use `destroy` instead")};var m=a.fn.datepicker,n=function(c){var d=Array.apply(null,arguments);d.shift();var e;if(this.each(function(){var b=a(this),f=b.data("datepicker"),g="object"==typeof c&&c;if(!f){var j=h(this,"date"),m=a.extend({},o,j,g),n=i(m.language),p=a.extend({},o,n,j,g);b.hasClass("input-daterange")||p.inputs?(a.extend(p,{inputs:p.inputs||b.find("input").toArray()}),f=new l(this,p)):f=new k(this,p),b.data("datepicker",f)}"string"==typeof c&&"function"==typeof f[c]&&(e=f[c].apply(f,d))}),e===b||e instanceof k||e instanceof l)return this;if(this.length>1)throw new Error("Using only allowed for the collection of a single element ("+c+" function)");return e};a.fn.datepicker=n;var o=a.fn.datepicker.defaults={assumeNearbyYear:!1,autoclose:!1,beforeShowDay:a.noop,beforeShowMonth:a.noop,beforeShowYear:a.noop,beforeShowDecade:a.noop,beforeShowCentury:a.noop,calendarWeeks:!1,clearBtn:!1,toggleActive:!1,daysOfWeekDisabled:[],daysOfWeekHighlighted:[],datesDisabled:[],endDate:1/0,forceParse:!0,format:"mm/dd/yyyy",keepEmptyValues:!1,keyboardNavigation:!0,language:"en",minViewMode:0,maxViewMode:4,multidate:!1,multidateSeparator:",",orientation:"auto",rtl:!1,startDate:-1/0,startView:0,todayBtn:!1,todayHighlight:!1,updateViewDate:!0,weekStart:0,disableTouchKeyboard:!1,enableOnReadonly:!0,showOnFocus:!0,zIndexOffset:10,container:"body",immediateUpdates:!1,title:"",templates:{leftArrow:"&#x00AB;",rightArrow:"&#x00BB;"},showWeekDays:!0},p=a.fn.datepicker.locale_opts=["format","rtl","weekStart"];a.fn.datepicker.Constructor=k;var q=a.fn.datepicker.dates={en:{days:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],daysShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],daysMin:["Su","Mo","Tu","We","Th","Fr","Sa"],months:["January","February","March","April","May","June","July","August","September","October","November","December"],monthsShort:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],today:"Today",clear:"Clear",titleFormat:"MM yyyy"}},r={viewModes:[{names:["days","month"],clsName:"days",e:"changeMonth"},{names:["months","year"],clsName:"months",e:"changeYear",navStep:1},{names:["years","decade"],clsName:"years",e:"changeDecade",navStep:10},{names:["decades","century"],clsName:"decades",e:"changeCentury",navStep:100},{names:["centuries","millennium"],clsName:"centuries",e:"changeMillennium",navStep:1e3}],validParts:/dd?|DD?|mm?|MM?|yy(?:yy)?/g,nonpunctuation:/[^ -\/:-@\u5e74\u6708\u65e5\[-`{-~\t\n\r]+/g,parseFormat:function(a){if("function"==typeof a.toValue&&"function"==typeof a.toDisplay)return a;var b=a.replace(this.validParts,"\0").split("\0"),c=a.match(this.validParts);if(!b||!b.length||!c||0===c.length)throw new Error("Invalid date format.");return{separators:b,parts:c}},parseDate:function(c,e,f,g){function h(a,b){return!0===b&&(b=10),a<100&&(a+=2e3)>(new Date).getFullYear()+b&&(a-=100),a}function i(){var a=this.slice(0,j[n].length),b=j[n].slice(0,a.length);return a.toLowerCase()===b.toLowerCase()}if(!c)return b;if(c instanceof Date)return c;if("string"==typeof e&&(e=r.parseFormat(e)),e.toValue)return e.toValue(c,e,f);var j,l,m,n,o,p={d:"moveDay",m:"moveMonth",w:"moveWeek",y:"moveYear"},s={yesterday:"-1d",today:"+0d",tomorrow:"+1d"};if(c in s&&(c=s[c]),/^[\-+]\d+[dmwy]([\s,]+[\-+]\d+[dmwy])*$/i.test(c)){for(j=c.match(/([\-+]\d+)([dmwy])/gi),c=new Date,n=0;n<j.length;n++)l=j[n].match(/([\-+]\d+)([dmwy])/i),m=Number(l[1]),o=p[l[2].toLowerCase()],c=k.prototype[o](c,m);return k.prototype._zero_utc_time(c)}j=c&&c.match(this.nonpunctuation)||[];var t,u,v={},w=["yyyy","yy","M","MM","m","mm","d","dd"],x={yyyy:function(a,b){return a.setUTCFullYear(g?h(b,g):b)},m:function(a,b){if(isNaN(a))return a;for(b-=1;b<0;)b+=12;for(b%=12,a.setUTCMonth(b);a.getUTCMonth()!==b;)a.setUTCDate(a.getUTCDate()-1);return a},d:function(a,b){return a.setUTCDate(b)}};x.yy=x.yyyy,x.M=x.MM=x.mm=x.m,x.dd=x.d,c=d();var y=e.parts.slice();if(j.length!==y.length&&(y=a(y).filter(function(b,c){return-1!==a.inArray(c,w)}).toArray()),j.length===y.length){var z;for(n=0,z=y.length;n<z;n++){if(t=parseInt(j[n],10),l=y[n],isNaN(t))switch(l){case"MM":u=a(q[f].months).filter(i),t=a.inArray(u[0],q[f].months)+1;break;case"M":u=a(q[f].monthsShort).filter(i),t=a.inArray(u[0],q[f].monthsShort)+1}v[l]=t}var A,B;for(n=0;n<w.length;n++)(B=w[n])in v&&!isNaN(v[B])&&(A=new Date(c),x[B](A,v[B]),isNaN(A)||(c=A))}return c},formatDate:function(b,c,d){if(!b)return"";if("string"==typeof c&&(c=r.parseFormat(c)),c.toDisplay)return c.toDisplay(b,c,d);var e={d:b.getUTCDate(),D:q[d].daysShort[b.getUTCDay()],DD:q[d].days[b.getUTCDay()],m:b.getUTCMonth()+1,M:q[d].monthsShort[b.getUTCMonth()],MM:q[d].months[b.getUTCMonth()],yy:b.getUTCFullYear().toString().substring(2),yyyy:b.getUTCFullYear()};e.dd=(e.d<10?"0":"")+e.d,e.mm=(e.m<10?"0":"")+e.m,b=[];for(var f=a.extend([],c.separators),g=0,h=c.parts.length;g<=h;g++)f.length&&b.push(f.shift()),b.push(e[c.parts[g]]);return b.join("")},
headTemplate:'<thead><tr><th colspan="7" class="datepicker-title"></th></tr><tr><th class="prev">'+o.templates.leftArrow+'</th><th colspan="5" class="datepicker-switch"></th><th class="next">'+o.templates.rightArrow+"</th></tr></thead>",contTemplate:'<tbody><tr><td colspan="7"></td></tr></tbody>',footTemplate:'<tfoot><tr><th colspan="7" class="today"></th></tr><tr><th colspan="7" class="clear"></th></tr></tfoot>'};r.template='<div class="datepicker"><div class="datepicker-days"><table class="table-condensed">'+r.headTemplate+"<tbody></tbody>"+r.footTemplate+'</table></div><div class="datepicker-months"><table class="table-condensed">'+r.headTemplate+r.contTemplate+r.footTemplate+'</table></div><div class="datepicker-years"><table class="table-condensed">'+r.headTemplate+r.contTemplate+r.footTemplate+'</table></div><div class="datepicker-decades"><table class="table-condensed">'+r.headTemplate+r.contTemplate+r.footTemplate+'</table></div><div class="datepicker-centuries"><table class="table-condensed">'+r.headTemplate+r.contTemplate+r.footTemplate+"</table></div></div>",a.fn.datepicker.DPGlobal=r,a.fn.datepicker.noConflict=function(){return a.fn.datepicker=m,this},a.fn.datepicker.version="1.9.0",a.fn.datepicker.deprecated=function(a){var b=window.console;b&&b.warn&&b.warn("DEPRECATED: "+a)},a(document).on("focus.datepicker.data-api click.datepicker.data-api",'[data-provide="datepicker"]',function(b){var c=a(this);c.data("datepicker")||(b.preventDefault(),n.call(c,"show"))}),a(function(){n.call(a('[data-provide="datepicker-inline"]'))})});
"use strict";
$.fn.datepicker.defaults.zIndexOffset = 10;

/*!@preserve
 * Tempus Dominus Bootstrap4 v5.39.0 (https://tempusdominus.github.io/bootstrap-4/)
 * Copyright 2016-2020 Jonathan Peterson and contributors
 * Licensed under MIT (https://github.com/tempusdominus/bootstrap-3/blob/master/LICENSE)
 */

if (typeof jQuery === 'undefined') {
  throw new Error('Tempus Dominus Bootstrap4\'s requires jQuery. jQuery must be included before Tempus Dominus Bootstrap4\'s JavaScript.');
}

+function ($) {
  var version = $.fn.jquery.split(' ')[0].split('.');
  if ((version[0] < 2 && version[1] < 9) || (version[0] === 1 && version[1] === 9 && version[2] < 1) || (version[0] >= 4)) {
    throw new Error('Tempus Dominus Bootstrap4\'s requires at least jQuery v3.0.0 but less than v4.0.0');
  }
}(jQuery);


if (typeof moment === 'undefined') {
  throw new Error('Tempus Dominus Bootstrap4\'s requires moment.js. Moment.js must be included before Tempus Dominus Bootstrap4\'s JavaScript.');
}

var version = moment.version.split('.')
if ((version[0] <= 2 && version[1] < 17) || (version[0] >= 3)) {
  throw new Error('Tempus Dominus Bootstrap4\'s requires at least moment.js v2.17.0 but less than v3.0.0');
}

+function () {

function _inheritsLoose(subClass, superClass) { subClass.prototype = Object.create(superClass.prototype); subClass.prototype.constructor = subClass; subClass.__proto__ = superClass; }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

// ReSharper disable once InconsistentNaming
var DateTimePicker = function ($, moment) {
  function escapeRegExp(text) {
    return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, '\\$&');
  }

  function isValidDate(date) {
    return Object.prototype.toString.call(date) === '[object Date]' && !isNaN(date.getTime());
  }

  function isValidDateTimeStr(str) {
    return isValidDate(new Date(str));
  } // ReSharper disable InconsistentNaming


  var trim = function trim(str) {
    return str.replace(/(^\s+)|(\s+$)/g, '');
  },
      NAME = 'datetimepicker',
      DATA_KEY = "" + NAME,
      EVENT_KEY = "." + DATA_KEY,
      DATA_API_KEY = '.data-api',
      Selector = {
    DATA_TOGGLE: "[data-toggle=\"" + DATA_KEY + "\"]"
  },
      ClassName = {
    INPUT: NAME + "-input"
  },
      Event = {
    CHANGE: "change" + EVENT_KEY,
    BLUR: "blur" + EVENT_KEY,
    KEYUP: "keyup" + EVENT_KEY,
    KEYDOWN: "keydown" + EVENT_KEY,
    FOCUS: "focus" + EVENT_KEY,
    CLICK_DATA_API: "click" + EVENT_KEY + DATA_API_KEY,
    //emitted
    UPDATE: "update" + EVENT_KEY,
    ERROR: "error" + EVENT_KEY,
    HIDE: "hide" + EVENT_KEY,
    SHOW: "show" + EVENT_KEY
  },
      DatePickerModes = [{
    CLASS_NAME: 'days',
    NAV_FUNCTION: 'M',
    NAV_STEP: 1
  }, {
    CLASS_NAME: 'months',
    NAV_FUNCTION: 'y',
    NAV_STEP: 1
  }, {
    CLASS_NAME: 'years',
    NAV_FUNCTION: 'y',
    NAV_STEP: 10
  }, {
    CLASS_NAME: 'decades',
    NAV_FUNCTION: 'y',
    NAV_STEP: 100
  }],
      KeyMap = {
    'up': 38,
    38: 'up',
    'down': 40,
    40: 'down',
    'left': 37,
    37: 'left',
    'right': 39,
    39: 'right',
    'tab': 9,
    9: 'tab',
    'escape': 27,
    27: 'escape',
    'enter': 13,
    13: 'enter',
    'pageUp': 33,
    33: 'pageUp',
    'pageDown': 34,
    34: 'pageDown',
    'shift': 16,
    16: 'shift',
    'control': 17,
    17: 'control',
    'space': 32,
    32: 'space',
    't': 84,
    84: 't',
    'delete': 46,
    46: 'delete'
  },
      ViewModes = ['times', 'days', 'months', 'years', 'decades'],
      keyState = {},
      keyPressHandled = {},
      optionsSortMap = {
    timeZone: -39,
    format: -38,
    dayViewHeaderFormat: -37,
    extraFormats: -36,
    stepping: -35,
    minDate: -34,
    maxDate: -33,
    useCurrent: -32,
    collapse: -31,
    locale: -30,
    defaultDate: -29,
    disabledDates: -28,
    enabledDates: -27,
    icons: -26,
    tooltips: -25,
    useStrict: -24,
    sideBySide: -23,
    daysOfWeekDisabled: -22,
    calendarWeeks: -21,
    viewMode: -20,
    toolbarPlacement: -19,
    buttons: -18,
    widgetPositioning: -17,
    widgetParent: -16,
    ignoreReadonly: -15,
    keepOpen: -14,
    focusOnShow: -13,
    inline: -12,
    keepInvalid: -11,
    keyBinds: -10,
    debug: -9,
    allowInputToggle: -8,
    disabledTimeIntervals: -7,
    disabledHours: -6,
    enabledHours: -5,
    viewDate: -4,
    allowMultidate: -3,
    multidateSeparator: -2,
    updateOnlyThroughDateOption: -1,
    date: 1
  },
      defaultFeatherIcons = {
    time: 'clock',
    date: 'calendar',
    up: 'arrow-up',
    down: 'arrow-down',
    previous: 'arrow-left',
    next: 'arrow-right',
    today: 'arrow-down-circle',
    clear: 'trash-2',
    close: 'x'
  };

  function optionsSortFn(optionKeyA, optionKeyB) {
    if (optionsSortMap[optionKeyA] && optionsSortMap[optionKeyB]) {
      if (optionsSortMap[optionKeyA] < 0 && optionsSortMap[optionKeyB] < 0) {
        return Math.abs(optionsSortMap[optionKeyB]) - Math.abs(optionsSortMap[optionKeyA]);
      } else if (optionsSortMap[optionKeyA] < 0) {
        return -1;
      } else if (optionsSortMap[optionKeyB] < 0) {
        return 1;
      }

      return optionsSortMap[optionKeyA] - optionsSortMap[optionKeyB];
    } else if (optionsSortMap[optionKeyA]) {
      return optionsSortMap[optionKeyA];
    } else if (optionsSortMap[optionKeyB]) {
      return optionsSortMap[optionKeyB];
    }

    return 0;
  }

  var Default = {
    timeZone: '',
    format: false,
    dayViewHeaderFormat: 'MMMM YYYY',
    extraFormats: false,
    stepping: 1,
    minDate: false,
    maxDate: false,
    useCurrent: true,
    collapse: true,
    locale: moment.locale(),
    defaultDate: false,
    disabledDates: false,
    enabledDates: false,
    icons: {
      type: 'class',
      time: 'fa fa-clock-o',
      date: 'fa fa-calendar',
      up: 'fa fa-arrow-up',
      down: 'fa fa-arrow-down',
      previous: 'fa fa-chevron-left',
      next: 'fa fa-chevron-right',
      today: 'fa fa-calendar-check-o',
      clear: 'fa fa-trash',
      close: 'fa fa-times'
    },
    tooltips: {
      today: 'Go to today',
      clear: 'Clear selection',
      close: 'Close the picker',
      selectMonth: 'Select Month',
      prevMonth: 'Previous Month',
      nextMonth: 'Next Month',
      selectYear: 'Select Year',
      prevYear: 'Previous Year',
      nextYear: 'Next Year',
      selectDecade: 'Select Decade',
      prevDecade: 'Previous Decade',
      nextDecade: 'Next Decade',
      prevCentury: 'Previous Century',
      nextCentury: 'Next Century',
      pickHour: 'Pick Hour',
      incrementHour: 'Increment Hour',
      decrementHour: 'Decrement Hour',
      pickMinute: 'Pick Minute',
      incrementMinute: 'Increment Minute',
      decrementMinute: 'Decrement Minute',
      pickSecond: 'Pick Second',
      incrementSecond: 'Increment Second',
      decrementSecond: 'Decrement Second',
      togglePeriod: 'Toggle Period',
      selectTime: 'Select Time',
      selectDate: 'Select Date'
    },
    useStrict: false,
    sideBySide: false,
    daysOfWeekDisabled: false,
    calendarWeeks: false,
    viewMode: 'days',
    toolbarPlacement: 'default',
    buttons: {
      showToday: false,
      showClear: false,
      showClose: false
    },
    widgetPositioning: {
      horizontal: 'auto',
      vertical: 'auto'
    },
    widgetParent: null,
    readonly: false,
    ignoreReadonly: false,
    keepOpen: false,
    focusOnShow: true,
    inline: false,
    keepInvalid: false,
    keyBinds: {
      up: function up() {
        if (!this.widget) {
          return false;
        }

        var d = this._dates[0] || this.getMoment();

        if (this.widget.find('.datepicker').is(':visible')) {
          this.date(d.clone().subtract(7, 'd'));
        } else {
          this.date(d.clone().add(this.stepping(), 'm'));
        }

        return true;
      },
      down: function down() {
        if (!this.widget) {
          this.show();
          return false;
        }

        var d = this._dates[0] || this.getMoment();

        if (this.widget.find('.datepicker').is(':visible')) {
          this.date(d.clone().add(7, 'd'));
        } else {
          this.date(d.clone().subtract(this.stepping(), 'm'));
        }

        return true;
      },
      'control up': function controlUp() {
        if (!this.widget) {
          return false;
        }

        var d = this._dates[0] || this.getMoment();

        if (this.widget.find('.datepicker').is(':visible')) {
          this.date(d.clone().subtract(1, 'y'));
        } else {
          this.date(d.clone().add(1, 'h'));
        }

        return true;
      },
      'control down': function controlDown() {
        if (!this.widget) {
          return false;
        }

        var d = this._dates[0] || this.getMoment();

        if (this.widget.find('.datepicker').is(':visible')) {
          this.date(d.clone().add(1, 'y'));
        } else {
          this.date(d.clone().subtract(1, 'h'));
        }

        return true;
      },
      left: function left() {
        if (!this.widget) {
          return false;
        }

        var d = this._dates[0] || this.getMoment();

        if (this.widget.find('.datepicker').is(':visible')) {
          this.date(d.clone().subtract(1, 'd'));
        }

        return true;
      },
      right: function right() {
        if (!this.widget) {
          return false;
        }

        var d = this._dates[0] || this.getMoment();

        if (this.widget.find('.datepicker').is(':visible')) {
          this.date(d.clone().add(1, 'd'));
        }

        return true;
      },
      pageUp: function pageUp() {
        if (!this.widget) {
          return false;
        }

        var d = this._dates[0] || this.getMoment();

        if (this.widget.find('.datepicker').is(':visible')) {
          this.date(d.clone().subtract(1, 'M'));
        }

        return true;
      },
      pageDown: function pageDown() {
        if (!this.widget) {
          return false;
        }

        var d = this._dates[0] || this.getMoment();

        if (this.widget.find('.datepicker').is(':visible')) {
          this.date(d.clone().add(1, 'M'));
        }

        return true;
      },
      enter: function enter() {
        if (!this.widget) {
          return false;
        }

        this.hide();
        return true;
      },
      escape: function escape() {
        if (!this.widget) {
          return false;
        }

        this.hide();
        return true;
      },
      'control space': function controlSpace() {
        if (!this.widget) {
          return false;
        }

        if (this.widget.find('.timepicker').is(':visible')) {
          this.widget.find('.btn[data-action="togglePeriod"]').click();
        }

        return true;
      },
      t: function t() {
        if (!this.widget) {
          return false;
        }

        this.date(this.getMoment());
        return true;
      },
      'delete': function _delete() {
        if (!this.widget) {
          return false;
        }

        this.clear();
        return true;
      }
    },
    debug: false,
    allowInputToggle: false,
    disabledTimeIntervals: false,
    disabledHours: false,
    enabledHours: false,
    viewDate: false,
    allowMultidate: false,
    multidateSeparator: ', ',
    updateOnlyThroughDateOption: false,
    promptTimeOnDateChange: false,
    promptTimeOnDateChangeTransitionDelay: 200
  }; // ReSharper restore InconsistentNaming
  // ReSharper disable once DeclarationHides
  // ReSharper disable once InconsistentNaming

  var DateTimePicker = /*#__PURE__*/function () {
    /** @namespace eData.dateOptions */

    /** @namespace moment.tz */
    function DateTimePicker(element, options) {
      this._options = this._getOptions(options);
      this._element = element;
      this._dates = [];
      this._datesFormatted = [];
      this._viewDate = null;
      this.unset = true;
      this.component = false;
      this.widget = false;
      this.use24Hours = null;
      this.actualFormat = null;
      this.parseFormats = null;
      this.currentViewMode = null;
      this.MinViewModeNumber = 0;
      this.isInitFormatting = false;
      this.isInit = false;
      this.isDateUpdateThroughDateOptionFromClientCode = false;
      this.hasInitDate = false;
      this.initDate = void 0;
      this._notifyChangeEventContext = void 0;
      this._currentPromptTimeTimeout = null;

      this._int();
    }
    /**
     * @return {string}
     */


    var _proto = DateTimePicker.prototype;

    //private
    _proto._int = function _int() {
      this.isInit = true;

      var targetInput = this._element.data('target-input');

      if (this._element.is('input')) {
        this.input = this._element;
      } else if (targetInput !== undefined) {
        if (targetInput === 'nearest') {
          this.input = this._element.find('input');
        } else {
          this.input = $(targetInput);
        }
      }

      this._dates = [];
      this._dates[0] = this.getMoment();
      this._viewDate = this.getMoment().clone();
      $.extend(true, this._options, this._dataToOptions());
      this.hasInitDate = false;
      this.initDate = void 0;
      this.options(this._options);
      this.isInitFormatting = true;

      this._initFormatting();

      this.isInitFormatting = false;

      if (this.input !== undefined && this.input.is('input') && this.input.val().trim().length !== 0) {
        this._setValue(this._parseInputDate(this.input.val().trim()), 0);
      } else if (this._options.defaultDate && this.input !== undefined && this.input.attr('placeholder') === undefined) {
        this._setValue(this._options.defaultDate, 0);
      }

      if (this.hasInitDate) {
        this.date(this.initDate);
      }

      if (this._options.inline) {
        this.show();
      }

      this.isInit = false;
    };

    _proto._update = function _update() {
      if (!this.widget) {
        return;
      }

      this._fillDate();

      this._fillTime();
    };

    _proto._setValue = function _setValue(targetMoment, index) {
      var noIndex = typeof index === 'undefined',
          isClear = !targetMoment && noIndex,
          isDateUpdateThroughDateOptionFromClientCode = this.isDateUpdateThroughDateOptionFromClientCode,
          isNotAllowedProgrammaticUpdate = !this.isInit && this._options.updateOnlyThroughDateOption && !isDateUpdateThroughDateOptionFromClientCode;
      var outpValue = '',
          isInvalid = false,
          oldDate = this.unset ? null : this._dates[index];

      if (!oldDate && !this.unset && noIndex && isClear) {
        oldDate = this._dates[this._dates.length - 1];
      } // case of calling setValue(null or false)


      if (!targetMoment) {
        if (isNotAllowedProgrammaticUpdate) {
          this._notifyEvent({
            type: DateTimePicker.Event.CHANGE,
            date: targetMoment,
            oldDate: oldDate,
            isClear: isClear,
            isInvalid: isInvalid,
            isDateUpdateThroughDateOptionFromClientCode: isDateUpdateThroughDateOptionFromClientCode,
            isInit: this.isInit
          });

          return;
        }

        if (!this._options.allowMultidate || this._dates.length === 1 || isClear) {
          this.unset = true;
          this._dates = [];
          this._datesFormatted = [];
        } else {
          outpValue = "" + this._element.data('date') + this._options.multidateSeparator;
          outpValue = oldDate && outpValue.replace("" + oldDate.format(this.actualFormat) + this._options.multidateSeparator, '').replace("" + this._options.multidateSeparator + this._options.multidateSeparator, '').replace(new RegExp(escapeRegExp(this._options.multidateSeparator) + "\\s*$"), '') || '';

          this._dates.splice(index, 1);

          this._datesFormatted.splice(index, 1);
        }

        outpValue = trim(outpValue);

        if (this.input !== undefined) {
          this.input.val(outpValue);
          this.input.trigger('input');
        }

        this._element.data('date', outpValue);

        this._notifyEvent({
          type: DateTimePicker.Event.CHANGE,
          date: false,
          oldDate: oldDate,
          isClear: isClear,
          isInvalid: isInvalid,
          isDateUpdateThroughDateOptionFromClientCode: isDateUpdateThroughDateOptionFromClientCode,
          isInit: this.isInit
        });

        this._update();

        return;
      }

      targetMoment = targetMoment.clone().locale(this._options.locale);

      if (this._hasTimeZone()) {
        targetMoment.tz(this._options.timeZone);
      }

      if (this._options.stepping !== 1) {
        targetMoment.minutes(Math.round(targetMoment.minutes() / this._options.stepping) * this._options.stepping).seconds(0);
      }

      if (this._isValid(targetMoment)) {
        if (isNotAllowedProgrammaticUpdate) {
          this._notifyEvent({
            type: DateTimePicker.Event.CHANGE,
            date: targetMoment.clone(),
            oldDate: oldDate,
            isClear: isClear,
            isInvalid: isInvalid,
            isDateUpdateThroughDateOptionFromClientCode: isDateUpdateThroughDateOptionFromClientCode,
            isInit: this.isInit
          });

          return;
        }

        this._dates[index] = targetMoment;
        this._datesFormatted[index] = targetMoment.format('YYYY-MM-DD');
        this._viewDate = targetMoment.clone();

        if (this._options.allowMultidate && this._dates.length > 1) {
          for (var i = 0; i < this._dates.length; i++) {
            outpValue += "" + this._dates[i].format(this.actualFormat) + this._options.multidateSeparator;
          }

          outpValue = outpValue.replace(new RegExp(this._options.multidateSeparator + "\\s*$"), '');
        } else {
          outpValue = this._dates[index].format(this.actualFormat);
        }

        outpValue = trim(outpValue);

        if (this.input !== undefined) {
          this.input.val(outpValue);
          this.input.trigger('input');
        }

        this._element.data('date', outpValue);

        this.unset = false;

        this._update();

        this._notifyEvent({
          type: DateTimePicker.Event.CHANGE,
          date: this._dates[index].clone(),
          oldDate: oldDate,
          isClear: isClear,
          isInvalid: isInvalid,
          isDateUpdateThroughDateOptionFromClientCode: isDateUpdateThroughDateOptionFromClientCode,
          isInit: this.isInit
        });
      } else {
        isInvalid = true;

        if (!this._options.keepInvalid) {
          if (this.input !== undefined) {
            this.input.val("" + (this.unset ? '' : this._dates[index].format(this.actualFormat)));
            this.input.trigger('input');
          }
        } else {
          this._notifyEvent({
            type: DateTimePicker.Event.CHANGE,
            date: targetMoment,
            oldDate: oldDate,
            isClear: isClear,
            isInvalid: isInvalid,
            isDateUpdateThroughDateOptionFromClientCode: isDateUpdateThroughDateOptionFromClientCode,
            isInit: this.isInit
          });
        }

        this._notifyEvent({
          type: DateTimePicker.Event.ERROR,
          date: targetMoment,
          oldDate: oldDate
        });
      }
    };

    _proto._change = function _change(e) {
      var val = $(e.target).val().trim(),
          parsedDate = val ? this._parseInputDate(val) : null;

      this._setValue(parsedDate, 0);

      e.stopImmediatePropagation();
      return false;
    } //noinspection JSMethodCanBeStatic
    ;

    _proto._getOptions = function _getOptions(options) {
      options = $.extend(true, {}, Default, options && options.icons && options.icons.type === 'feather' ? {
        icons: defaultFeatherIcons
      } : {}, options);
      return options;
    };

    _proto._hasTimeZone = function _hasTimeZone() {
      return moment.tz !== undefined && this._options.timeZone !== undefined && this._options.timeZone !== null && this._options.timeZone !== '';
    };

    _proto._isEnabled = function _isEnabled(granularity) {
      if (typeof granularity !== 'string' || granularity.length > 1) {
        throw new TypeError('isEnabled expects a single character string parameter');
      }

      switch (granularity) {
        case 'y':
          return this.actualFormat.indexOf('Y') !== -1;

        case 'M':
          return this.actualFormat.indexOf('M') !== -1;

        case 'd':
          return this.actualFormat.toLowerCase().indexOf('d') !== -1;

        case 'h':
        case 'H':
          return this.actualFormat.toLowerCase().indexOf('h') !== -1;

        case 'm':
          return this.actualFormat.indexOf('m') !== -1;

        case 's':
          return this.actualFormat.indexOf('s') !== -1;

        case 'a':
        case 'A':
          return this.actualFormat.toLowerCase().indexOf('a') !== -1;

        default:
          return false;
      }
    };

    _proto._hasTime = function _hasTime() {
      return this._isEnabled('h') || this._isEnabled('m') || this._isEnabled('s');
    };

    _proto._hasDate = function _hasDate() {
      return this._isEnabled('y') || this._isEnabled('M') || this._isEnabled('d');
    };

    _proto._dataToOptions = function _dataToOptions() {
      var eData = this._element.data();

      var dataOptions = {};

      if (eData.dateOptions && eData.dateOptions instanceof Object) {
        dataOptions = $.extend(true, dataOptions, eData.dateOptions);
      }

      $.each(this._options, function (key) {
        var attributeName = "date" + key.charAt(0).toUpperCase() + key.slice(1); //todo data api key

        if (eData[attributeName] !== undefined) {
          dataOptions[key] = eData[attributeName];
        } else {
          delete dataOptions[key];
        }
      });
      return dataOptions;
    };

    _proto._format = function _format() {
      return this._options.format || 'YYYY-MM-DD HH:mm';
    };

    _proto._areSameDates = function _areSameDates(a, b) {
      var format = this._format();

      return a && b && (a.isSame(b) || moment(a.format(format), format).isSame(moment(b.format(format), format)));
    };

    _proto._notifyEvent = function _notifyEvent(e) {
      if (e.type === DateTimePicker.Event.CHANGE) {
        this._notifyChangeEventContext = this._notifyChangeEventContext || 0;
        this._notifyChangeEventContext++;

        if (e.date && this._areSameDates(e.date, e.oldDate) || !e.isClear && !e.date && !e.oldDate || this._notifyChangeEventContext > 1) {
          this._notifyChangeEventContext = void 0;
          return;
        }

        this._handlePromptTimeIfNeeded(e);
      }

      this._element.trigger(e);

      this._notifyChangeEventContext = void 0;
    };

    _proto._handlePromptTimeIfNeeded = function _handlePromptTimeIfNeeded(e) {
      if (this._options.promptTimeOnDateChange) {
        if (!e.oldDate && this._options.useCurrent) {
          // First time ever. If useCurrent option is set to true (default), do nothing
          // because the first date is selected automatically.
          return;
        } else if (e.oldDate && e.date && (e.oldDate.format('YYYY-MM-DD') === e.date.format('YYYY-MM-DD') || e.oldDate.format('YYYY-MM-DD') !== e.date.format('YYYY-MM-DD') && e.oldDate.format('HH:mm:ss') !== e.date.format('HH:mm:ss'))) {
          // Date didn't change (time did) or date changed because time did.
          return;
        }

        var that = this;
        clearTimeout(this._currentPromptTimeTimeout);
        this._currentPromptTimeTimeout = setTimeout(function () {
          if (that.widget) {
            that.widget.find('[data-action="togglePicker"]').click();
          }
        }, this._options.promptTimeOnDateChangeTransitionDelay);
      }
    };

    _proto._viewUpdate = function _viewUpdate(e) {
      if (e === 'y') {
        e = 'YYYY';
      }

      this._notifyEvent({
        type: DateTimePicker.Event.UPDATE,
        change: e,
        viewDate: this._viewDate.clone()
      });
    };

    _proto._showMode = function _showMode(dir) {
      if (!this.widget) {
        return;
      }

      if (dir) {
        this.currentViewMode = Math.max(this.MinViewModeNumber, Math.min(3, this.currentViewMode + dir));
      }

      this.widget.find('.datepicker > div').hide().filter(".datepicker-" + DatePickerModes[this.currentViewMode].CLASS_NAME).show();
    };

    _proto._isInDisabledDates = function _isInDisabledDates(testDate) {
      return this._options.disabledDates[testDate.format('YYYY-MM-DD')] === true;
    };

    _proto._isInEnabledDates = function _isInEnabledDates(testDate) {
      return this._options.enabledDates[testDate.format('YYYY-MM-DD')] === true;
    };

    _proto._isInDisabledHours = function _isInDisabledHours(testDate) {
      return this._options.disabledHours[testDate.format('H')] === true;
    };

    _proto._isInEnabledHours = function _isInEnabledHours(testDate) {
      return this._options.enabledHours[testDate.format('H')] === true;
    };

    _proto._isValid = function _isValid(targetMoment, granularity) {
      if (!targetMoment || !targetMoment.isValid()) {
        return false;
      }

      if (this._options.disabledDates && granularity === 'd' && this._isInDisabledDates(targetMoment)) {
        return false;
      }

      if (this._options.enabledDates && granularity === 'd' && !this._isInEnabledDates(targetMoment)) {
        return false;
      }

      if (this._options.minDate && targetMoment.isBefore(this._options.minDate, granularity)) {
        return false;
      }

      if (this._options.maxDate && targetMoment.isAfter(this._options.maxDate, granularity)) {
        return false;
      }

      if (this._options.daysOfWeekDisabled && granularity === 'd' && this._options.daysOfWeekDisabled.indexOf(targetMoment.day()) !== -1) {
        return false;
      }

      if (this._options.disabledHours && (granularity === 'h' || granularity === 'm' || granularity === 's') && this._isInDisabledHours(targetMoment)) {
        return false;
      }

      if (this._options.enabledHours && (granularity === 'h' || granularity === 'm' || granularity === 's') && !this._isInEnabledHours(targetMoment)) {
        return false;
      }

      if (this._options.disabledTimeIntervals && (granularity === 'h' || granularity === 'm' || granularity === 's')) {
        var found = false;
        $.each(this._options.disabledTimeIntervals, function () {
          if (targetMoment.isBetween(this[0], this[1])) {
            found = true;
            return false;
          }
        });

        if (found) {
          return false;
        }
      }

      return true;
    };

    _proto._parseInputDate = function _parseInputDate(inputDate, _temp) {
      var _ref = _temp === void 0 ? {} : _temp,
          _ref$isPickerShow = _ref.isPickerShow,
          isPickerShow = _ref$isPickerShow === void 0 ? false : _ref$isPickerShow;

      if (this._options.parseInputDate === undefined || isPickerShow) {
        if (!moment.isMoment(inputDate)) {
          inputDate = this.getMoment(inputDate);
        }
      } else {
        inputDate = this._options.parseInputDate(inputDate);
      } //inputDate.locale(this.options.locale);


      return inputDate;
    };

    _proto._keydown = function _keydown(e) {
      var handler = null,
          index,
          index2,
          keyBindKeys,
          allModifiersPressed;
      var pressedKeys = [],
          pressedModifiers = {},
          currentKey = e.which,
          pressed = 'p';
      keyState[currentKey] = pressed;

      for (index in keyState) {
        if (keyState.hasOwnProperty(index) && keyState[index] === pressed) {
          pressedKeys.push(index);

          if (parseInt(index, 10) !== currentKey) {
            pressedModifiers[index] = true;
          }
        }
      }

      for (index in this._options.keyBinds) {
        if (this._options.keyBinds.hasOwnProperty(index) && typeof this._options.keyBinds[index] === 'function') {
          keyBindKeys = index.split(' ');

          if (keyBindKeys.length === pressedKeys.length && KeyMap[currentKey] === keyBindKeys[keyBindKeys.length - 1]) {
            allModifiersPressed = true;

            for (index2 = keyBindKeys.length - 2; index2 >= 0; index2--) {
              if (!(KeyMap[keyBindKeys[index2]] in pressedModifiers)) {
                allModifiersPressed = false;
                break;
              }
            }

            if (allModifiersPressed) {
              handler = this._options.keyBinds[index];
              break;
            }
          }
        }
      }

      if (handler) {
        if (handler.call(this)) {
          e.stopPropagation();
          e.preventDefault();
        }
      }
    } //noinspection JSMethodCanBeStatic,SpellCheckingInspection
    ;

    _proto._keyup = function _keyup(e) {
      keyState[e.which] = 'r';

      if (keyPressHandled[e.which]) {
        keyPressHandled[e.which] = false;
        e.stopPropagation();
        e.preventDefault();
      }
    };

    _proto._indexGivenDates = function _indexGivenDates(givenDatesArray) {
      // Store given enabledDates and disabledDates as keys.
      // This way we can check their existence in O(1) time instead of looping through whole array.
      // (for example: options.enabledDates['2014-02-27'] === true)
      var givenDatesIndexed = {},
          self = this;
      $.each(givenDatesArray, function () {
        var dDate = self._parseInputDate(this);

        if (dDate.isValid()) {
          givenDatesIndexed[dDate.format('YYYY-MM-DD')] = true;
        }
      });
      return Object.keys(givenDatesIndexed).length ? givenDatesIndexed : false;
    };

    _proto._indexGivenHours = function _indexGivenHours(givenHoursArray) {
      // Store given enabledHours and disabledHours as keys.
      // This way we can check their existence in O(1) time instead of looping through whole array.
      // (for example: options.enabledHours['2014-02-27'] === true)
      var givenHoursIndexed = {};
      $.each(givenHoursArray, function () {
        givenHoursIndexed[this] = true;
      });
      return Object.keys(givenHoursIndexed).length ? givenHoursIndexed : false;
    };

    _proto._initFormatting = function _initFormatting() {
      var format = this._options.format || 'L LT',
          self = this;
      this.actualFormat = format.replace(/(\[[^\[]*])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g, function (formatInput) {
        return (self.isInitFormatting && self._options.date === null ? self.getMoment() : self._dates[0]).localeData().longDateFormat(formatInput) || formatInput; //todo taking the first date should be ok
      });
      this.parseFormats = this._options.extraFormats ? this._options.extraFormats.slice() : [];

      if (this.parseFormats.indexOf(format) < 0 && this.parseFormats.indexOf(this.actualFormat) < 0) {
        this.parseFormats.push(this.actualFormat);
      }

      this.use24Hours = this.actualFormat.toLowerCase().indexOf('a') < 1 && this.actualFormat.replace(/\[.*?]/g, '').indexOf('h') < 1;

      if (this._isEnabled('y')) {
        this.MinViewModeNumber = 2;
      }

      if (this._isEnabled('M')) {
        this.MinViewModeNumber = 1;
      }

      if (this._isEnabled('d')) {
        this.MinViewModeNumber = 0;
      }

      this.currentViewMode = Math.max(this.MinViewModeNumber, this.currentViewMode);

      if (!this.unset) {
        this._setValue(this._dates[0], 0);
      }
    };

    _proto._getLastPickedDate = function _getLastPickedDate() {
      var lastPickedDate = this._dates[this._getLastPickedDateIndex()];

      if (!lastPickedDate && this._options.allowMultidate) {
        lastPickedDate = moment(new Date());
      }

      return lastPickedDate;
    };

    _proto._getLastPickedDateIndex = function _getLastPickedDateIndex() {
      return this._dates.length - 1;
    } //public
    ;

    _proto.getMoment = function getMoment(d) {
      var returnMoment;

      if (d === undefined || d === null) {
        // TODO: Should this use format?
        returnMoment = moment().clone().locale(this._options.locale);
      } else if (this._hasTimeZone()) {
        // There is a string to parse and a default time zone
        // parse with the tz function which takes a default time zone if it is not in the format string
        returnMoment = moment.tz(d, this.parseFormats, this._options.locale, this._options.useStrict, this._options.timeZone);
      } else {
        returnMoment = moment(d, this.parseFormats, this._options.locale, this._options.useStrict);
      }

      if (this._hasTimeZone()) {
        returnMoment.tz(this._options.timeZone);
      }

      return returnMoment;
    };

    _proto.toggle = function toggle() {
      return this.widget ? this.hide() : this.show();
    };

    _proto.readonly = function readonly(_readonly) {
      if (arguments.length === 0) {
        return this._options.readonly;
      }

      if (typeof _readonly !== 'boolean') {
        throw new TypeError('readonly() expects a boolean parameter');
      }

      this._options.readonly = _readonly;

      if (this.input !== undefined) {
        this.input.prop('readonly', this._options.readonly);
      }

      if (this.widget) {
        this.hide();
        this.show();
      }
    };

    _proto.ignoreReadonly = function ignoreReadonly(_ignoreReadonly) {
      if (arguments.length === 0) {
        return this._options.ignoreReadonly;
      }

      if (typeof _ignoreReadonly !== 'boolean') {
        throw new TypeError('ignoreReadonly() expects a boolean parameter');
      }

      this._options.ignoreReadonly = _ignoreReadonly;
    };

    _proto.options = function options(newOptions) {
      if (arguments.length === 0) {
        return $.extend(true, {}, this._options);
      }

      if (!(newOptions instanceof Object)) {
        throw new TypeError('options() this.options parameter should be an object');
      }

      $.extend(true, this._options, newOptions);
      var self = this,
          optionsKeys = Object.keys(this._options).sort(optionsSortFn);
      $.each(optionsKeys, function (i, key) {
        var value = self._options[key];

        if (self[key] !== undefined) {
          if (self.isInit && key === 'date') {
            self.hasInitDate = true;
            self.initDate = value;
            return;
          }

          self[key](value);
        }
      });
    };

    _proto.date = function date(newDate, index) {
      index = index || 0;

      if (arguments.length === 0) {
        if (this.unset) {
          return null;
        }

        if (this._options.allowMultidate) {
          return this._dates.join(this._options.multidateSeparator);
        } else {
          return this._dates[index].clone();
        }
      }

      if (newDate !== null && typeof newDate !== 'string' && !moment.isMoment(newDate) && !(newDate instanceof Date)) {
        throw new TypeError('date() parameter must be one of [null, string, moment or Date]');
      }

      if (typeof newDate === 'string' && isValidDateTimeStr(newDate)) {
        newDate = new Date(newDate);
      }

      this._setValue(newDate === null ? null : this._parseInputDate(newDate), index);
    };

    _proto.updateOnlyThroughDateOption = function updateOnlyThroughDateOption(_updateOnlyThroughDateOption) {
      if (typeof _updateOnlyThroughDateOption !== 'boolean') {
        throw new TypeError('updateOnlyThroughDateOption() expects a boolean parameter');
      }

      this._options.updateOnlyThroughDateOption = _updateOnlyThroughDateOption;
    };

    _proto.format = function format(newFormat) {
      if (arguments.length === 0) {
        return this._options.format;
      }

      if (typeof newFormat !== 'string' && (typeof newFormat !== 'boolean' || newFormat !== false)) {
        throw new TypeError("format() expects a string or boolean:false parameter " + newFormat);
      }

      this._options.format = newFormat;

      if (this.actualFormat) {
        this._initFormatting(); // reinitialize formatting

      }
    };

    _proto.timeZone = function timeZone(newZone) {
      if (arguments.length === 0) {
        return this._options.timeZone;
      }

      if (typeof newZone !== 'string') {
        throw new TypeError('newZone() expects a string parameter');
      }

      this._options.timeZone = newZone;
    };

    _proto.dayViewHeaderFormat = function dayViewHeaderFormat(newFormat) {
      if (arguments.length === 0) {
        return this._options.dayViewHeaderFormat;
      }

      if (typeof newFormat !== 'string') {
        throw new TypeError('dayViewHeaderFormat() expects a string parameter');
      }

      this._options.dayViewHeaderFormat = newFormat;
    };

    _proto.extraFormats = function extraFormats(formats) {
      if (arguments.length === 0) {
        return this._options.extraFormats;
      }

      if (formats !== false && !(formats instanceof Array)) {
        throw new TypeError('extraFormats() expects an array or false parameter');
      }

      this._options.extraFormats = formats;

      if (this.parseFormats) {
        this._initFormatting(); // reinit formatting

      }
    };

    _proto.disabledDates = function disabledDates(dates) {
      if (arguments.length === 0) {
        return this._options.disabledDates ? $.extend({}, this._options.disabledDates) : this._options.disabledDates;
      }

      if (!dates) {
        this._options.disabledDates = false;

        this._update();

        return true;
      }

      if (!(dates instanceof Array)) {
        throw new TypeError('disabledDates() expects an array parameter');
      }

      this._options.disabledDates = this._indexGivenDates(dates);
      this._options.enabledDates = false;

      this._update();
    };

    _proto.enabledDates = function enabledDates(dates) {
      if (arguments.length === 0) {
        return this._options.enabledDates ? $.extend({}, this._options.enabledDates) : this._options.enabledDates;
      }

      if (!dates) {
        this._options.enabledDates = false;

        this._update();

        return true;
      }

      if (!(dates instanceof Array)) {
        throw new TypeError('enabledDates() expects an array parameter');
      }

      this._options.enabledDates = this._indexGivenDates(dates);
      this._options.disabledDates = false;

      this._update();
    };

    _proto.daysOfWeekDisabled = function daysOfWeekDisabled(_daysOfWeekDisabled) {
      if (arguments.length === 0) {
        return this._options.daysOfWeekDisabled.splice(0);
      }

      if (typeof _daysOfWeekDisabled === 'boolean' && !_daysOfWeekDisabled) {
        this._options.daysOfWeekDisabled = false;

        this._update();

        return true;
      }

      if (!(_daysOfWeekDisabled instanceof Array)) {
        throw new TypeError('daysOfWeekDisabled() expects an array parameter');
      }

      this._options.daysOfWeekDisabled = _daysOfWeekDisabled.reduce(function (previousValue, currentValue) {
        currentValue = parseInt(currentValue, 10);

        if (currentValue > 6 || currentValue < 0 || isNaN(currentValue)) {
          return previousValue;
        }

        if (previousValue.indexOf(currentValue) === -1) {
          previousValue.push(currentValue);
        }

        return previousValue;
      }, []).sort();

      if (this._options.useCurrent && !this._options.keepInvalid) {
        for (var i = 0; i < this._dates.length; i++) {
          var tries = 0;

          while (!this._isValid(this._dates[i], 'd')) {
            this._dates[i].add(1, 'd');

            if (tries === 31) {
              throw 'Tried 31 times to find a valid date';
            }

            tries++;
          }

          this._setValue(this._dates[i], i);
        }
      }

      this._update();
    };

    _proto.maxDate = function maxDate(_maxDate) {
      if (arguments.length === 0) {
        return this._options.maxDate ? this._options.maxDate.clone() : this._options.maxDate;
      }

      if (typeof _maxDate === 'boolean' && _maxDate === false) {
        this._options.maxDate = false;

        this._update();

        return true;
      }

      if (typeof _maxDate === 'string') {
        if (_maxDate === 'now' || _maxDate === 'moment') {
          _maxDate = this.getMoment();
        }
      }

      var parsedDate = this._parseInputDate(_maxDate);

      if (!parsedDate.isValid()) {
        throw new TypeError("maxDate() Could not parse date parameter: " + _maxDate);
      }

      if (this._options.minDate && parsedDate.isBefore(this._options.minDate)) {
        throw new TypeError("maxDate() date parameter is before this.options.minDate: " + parsedDate.format(this.actualFormat));
      }

      this._options.maxDate = parsedDate;

      for (var i = 0; i < this._dates.length; i++) {
        if (this._options.useCurrent && !this._options.keepInvalid && this._dates[i].isAfter(_maxDate)) {
          this._setValue(this._options.maxDate, i);
        }
      }

      if (this._viewDate.isAfter(parsedDate)) {
        this._viewDate = parsedDate.clone().subtract(this._options.stepping, 'm');
      }

      this._update();
    };

    _proto.minDate = function minDate(_minDate) {
      if (arguments.length === 0) {
        return this._options.minDate ? this._options.minDate.clone() : this._options.minDate;
      }

      if (typeof _minDate === 'boolean' && _minDate === false) {
        this._options.minDate = false;

        this._update();

        return true;
      }

      if (typeof _minDate === 'string') {
        if (_minDate === 'now' || _minDate === 'moment') {
          _minDate = this.getMoment();
        }
      }

      var parsedDate = this._parseInputDate(_minDate);

      if (!parsedDate.isValid()) {
        throw new TypeError("minDate() Could not parse date parameter: " + _minDate);
      }

      if (this._options.maxDate && parsedDate.isAfter(this._options.maxDate)) {
        throw new TypeError("minDate() date parameter is after this.options.maxDate: " + parsedDate.format(this.actualFormat));
      }

      this._options.minDate = parsedDate;

      for (var i = 0; i < this._dates.length; i++) {
        if (this._options.useCurrent && !this._options.keepInvalid && this._dates[i].isBefore(_minDate)) {
          this._setValue(this._options.minDate, i);
        }
      }

      if (this._viewDate.isBefore(parsedDate)) {
        this._viewDate = parsedDate.clone().add(this._options.stepping, 'm');
      }

      this._update();
    };

    _proto.defaultDate = function defaultDate(_defaultDate) {
      if (arguments.length === 0) {
        return this._options.defaultDate ? this._options.defaultDate.clone() : this._options.defaultDate;
      }

      if (!_defaultDate) {
        this._options.defaultDate = false;
        return true;
      }

      if (typeof _defaultDate === 'string') {
        if (_defaultDate === 'now' || _defaultDate === 'moment') {
          _defaultDate = this.getMoment();
        } else {
          _defaultDate = this.getMoment(_defaultDate);
        }
      }

      var parsedDate = this._parseInputDate(_defaultDate);

      if (!parsedDate.isValid()) {
        throw new TypeError("defaultDate() Could not parse date parameter: " + _defaultDate);
      }

      if (!this._isValid(parsedDate)) {
        throw new TypeError('defaultDate() date passed is invalid according to component setup validations');
      }

      this._options.defaultDate = parsedDate;

      if (this._options.defaultDate && this._options.inline || this.input !== undefined && this.input.val().trim() === '') {
        this._setValue(this._options.defaultDate, 0);
      }
    };

    _proto.locale = function locale(_locale) {
      if (arguments.length === 0) {
        return this._options.locale;
      }

      if (!moment.localeData(_locale)) {
        throw new TypeError("locale() locale " + _locale + " is not loaded from moment locales!");
      }

      this._options.locale = _locale;

      for (var i = 0; i < this._dates.length; i++) {
        this._dates[i].locale(this._options.locale);
      }

      this._viewDate.locale(this._options.locale);

      if (this.actualFormat) {
        this._initFormatting(); // reinitialize formatting

      }

      if (this.widget) {
        this.hide();
        this.show();
      }
    };

    _proto.stepping = function stepping(_stepping) {
      if (arguments.length === 0) {
        return this._options.stepping;
      }

      _stepping = parseInt(_stepping, 10);

      if (isNaN(_stepping) || _stepping < 1) {
        _stepping = 1;
      }

      this._options.stepping = _stepping;
    };

    _proto.useCurrent = function useCurrent(_useCurrent) {
      var useCurrentOptions = ['year', 'month', 'day', 'hour', 'minute'];

      if (arguments.length === 0) {
        return this._options.useCurrent;
      }

      if (typeof _useCurrent !== 'boolean' && typeof _useCurrent !== 'string') {
        throw new TypeError('useCurrent() expects a boolean or string parameter');
      }

      if (typeof _useCurrent === 'string' && useCurrentOptions.indexOf(_useCurrent.toLowerCase()) === -1) {
        throw new TypeError("useCurrent() expects a string parameter of " + useCurrentOptions.join(', '));
      }

      this._options.useCurrent = _useCurrent;
    };

    _proto.collapse = function collapse(_collapse) {
      if (arguments.length === 0) {
        return this._options.collapse;
      }

      if (typeof _collapse !== 'boolean') {
        throw new TypeError('collapse() expects a boolean parameter');
      }

      if (this._options.collapse === _collapse) {
        return true;
      }

      this._options.collapse = _collapse;

      if (this.widget) {
        this.hide();
        this.show();
      }
    };

    _proto.icons = function icons(_icons) {
      if (arguments.length === 0) {
        return $.extend({}, this._options.icons);
      }

      if (!(_icons instanceof Object)) {
        throw new TypeError('icons() expects parameter to be an Object');
      }

      $.extend(this._options.icons, _icons);

      if (this.widget) {
        this.hide();
        this.show();
      }
    };

    _proto.tooltips = function tooltips(_tooltips) {
      if (arguments.length === 0) {
        return $.extend({}, this._options.tooltips);
      }

      if (!(_tooltips instanceof Object)) {
        throw new TypeError('tooltips() expects parameter to be an Object');
      }

      $.extend(this._options.tooltips, _tooltips);

      if (this.widget) {
        this.hide();
        this.show();
      }
    };

    _proto.useStrict = function useStrict(_useStrict) {
      if (arguments.length === 0) {
        return this._options.useStrict;
      }

      if (typeof _useStrict !== 'boolean') {
        throw new TypeError('useStrict() expects a boolean parameter');
      }

      this._options.useStrict = _useStrict;
    };

    _proto.sideBySide = function sideBySide(_sideBySide) {
      if (arguments.length === 0) {
        return this._options.sideBySide;
      }

      if (typeof _sideBySide !== 'boolean') {
        throw new TypeError('sideBySide() expects a boolean parameter');
      }

      this._options.sideBySide = _sideBySide;

      if (this.widget) {
        this.hide();
        this.show();
      }
    };

    _proto.viewMode = function viewMode(_viewMode) {
      if (arguments.length === 0) {
        return this._options.viewMode;
      }

      if (typeof _viewMode !== 'string') {
        throw new TypeError('viewMode() expects a string parameter');
      }

      if (DateTimePicker.ViewModes.indexOf(_viewMode) === -1) {
        throw new TypeError("viewMode() parameter must be one of (" + DateTimePicker.ViewModes.join(', ') + ") value");
      }

      this._options.viewMode = _viewMode;
      this.currentViewMode = Math.max(DateTimePicker.ViewModes.indexOf(_viewMode) - 1, this.MinViewModeNumber);

      this._showMode();
    };

    _proto.calendarWeeks = function calendarWeeks(_calendarWeeks) {
      if (arguments.length === 0) {
        return this._options.calendarWeeks;
      }

      if (typeof _calendarWeeks !== 'boolean') {
        throw new TypeError('calendarWeeks() expects parameter to be a boolean value');
      }

      this._options.calendarWeeks = _calendarWeeks;

      this._update();
    };

    _proto.buttons = function buttons(_buttons) {
      if (arguments.length === 0) {
        return $.extend({}, this._options.buttons);
      }

      if (!(_buttons instanceof Object)) {
        throw new TypeError('buttons() expects parameter to be an Object');
      }

      $.extend(this._options.buttons, _buttons);

      if (typeof this._options.buttons.showToday !== 'boolean') {
        throw new TypeError('buttons.showToday expects a boolean parameter');
      }

      if (typeof this._options.buttons.showClear !== 'boolean') {
        throw new TypeError('buttons.showClear expects a boolean parameter');
      }

      if (typeof this._options.buttons.showClose !== 'boolean') {
        throw new TypeError('buttons.showClose expects a boolean parameter');
      }

      if (this.widget) {
        this.hide();
        this.show();
      }
    };

    _proto.keepOpen = function keepOpen(_keepOpen) {
      if (arguments.length === 0) {
        return this._options.keepOpen;
      }

      if (typeof _keepOpen !== 'boolean') {
        throw new TypeError('keepOpen() expects a boolean parameter');
      }

      this._options.keepOpen = _keepOpen;
    };

    _proto.focusOnShow = function focusOnShow(_focusOnShow) {
      if (arguments.length === 0) {
        return this._options.focusOnShow;
      }

      if (typeof _focusOnShow !== 'boolean') {
        throw new TypeError('focusOnShow() expects a boolean parameter');
      }

      this._options.focusOnShow = _focusOnShow;
    };

    _proto.inline = function inline(_inline) {
      if (arguments.length === 0) {
        return this._options.inline;
      }

      if (typeof _inline !== 'boolean') {
        throw new TypeError('inline() expects a boolean parameter');
      }

      this._options.inline = _inline;
    };

    _proto.clear = function clear() {
      this._setValue(null); //todo

    };

    _proto.keyBinds = function keyBinds(_keyBinds) {
      if (arguments.length === 0) {
        return this._options.keyBinds;
      }

      this._options.keyBinds = _keyBinds;
    };

    _proto.debug = function debug(_debug) {
      if (typeof _debug !== 'boolean') {
        throw new TypeError('debug() expects a boolean parameter');
      }

      this._options.debug = _debug;
    };

    _proto.allowInputToggle = function allowInputToggle(_allowInputToggle) {
      if (arguments.length === 0) {
        return this._options.allowInputToggle;
      }

      if (typeof _allowInputToggle !== 'boolean') {
        throw new TypeError('allowInputToggle() expects a boolean parameter');
      }

      this._options.allowInputToggle = _allowInputToggle;
    };

    _proto.keepInvalid = function keepInvalid(_keepInvalid) {
      if (arguments.length === 0) {
        return this._options.keepInvalid;
      }

      if (typeof _keepInvalid !== 'boolean') {
        throw new TypeError('keepInvalid() expects a boolean parameter');
      }

      this._options.keepInvalid = _keepInvalid;
    };

    _proto.datepickerInput = function datepickerInput(_datepickerInput) {
      if (arguments.length === 0) {
        return this._options.datepickerInput;
      }

      if (typeof _datepickerInput !== 'string') {
        throw new TypeError('datepickerInput() expects a string parameter');
      }

      this._options.datepickerInput = _datepickerInput;
    };

    _proto.parseInputDate = function parseInputDate(_parseInputDate2) {
      if (arguments.length === 0) {
        return this._options.parseInputDate;
      }

      if (typeof _parseInputDate2 !== 'function') {
        throw new TypeError('parseInputDate() should be as function');
      }

      this._options.parseInputDate = _parseInputDate2;
    };

    _proto.disabledTimeIntervals = function disabledTimeIntervals(_disabledTimeIntervals) {
      if (arguments.length === 0) {
        return this._options.disabledTimeIntervals ? $.extend({}, this._options.disabledTimeIntervals) : this._options.disabledTimeIntervals;
      }

      if (!_disabledTimeIntervals) {
        this._options.disabledTimeIntervals = false;

        this._update();

        return true;
      }

      if (!(_disabledTimeIntervals instanceof Array)) {
        throw new TypeError('disabledTimeIntervals() expects an array parameter');
      }

      this._options.disabledTimeIntervals = _disabledTimeIntervals;

      this._update();
    };

    _proto.disabledHours = function disabledHours(hours) {
      if (arguments.length === 0) {
        return this._options.disabledHours ? $.extend({}, this._options.disabledHours) : this._options.disabledHours;
      }

      if (!hours) {
        this._options.disabledHours = false;

        this._update();

        return true;
      }

      if (!(hours instanceof Array)) {
        throw new TypeError('disabledHours() expects an array parameter');
      }

      this._options.disabledHours = this._indexGivenHours(hours);
      this._options.enabledHours = false;

      if (this._options.useCurrent && !this._options.keepInvalid) {
        for (var i = 0; i < this._dates.length; i++) {
          var tries = 0;

          while (!this._isValid(this._dates[i], 'h')) {
            this._dates[i].add(1, 'h');

            if (tries === 24) {
              throw 'Tried 24 times to find a valid date';
            }

            tries++;
          }

          this._setValue(this._dates[i], i);
        }
      }

      this._update();
    };

    _proto.enabledHours = function enabledHours(hours) {
      if (arguments.length === 0) {
        return this._options.enabledHours ? $.extend({}, this._options.enabledHours) : this._options.enabledHours;
      }

      if (!hours) {
        this._options.enabledHours = false;

        this._update();

        return true;
      }

      if (!(hours instanceof Array)) {
        throw new TypeError('enabledHours() expects an array parameter');
      }

      this._options.enabledHours = this._indexGivenHours(hours);
      this._options.disabledHours = false;

      if (this._options.useCurrent && !this._options.keepInvalid) {
        for (var i = 0; i < this._dates.length; i++) {
          var tries = 0;

          while (!this._isValid(this._dates[i], 'h')) {
            this._dates[i].add(1, 'h');

            if (tries === 24) {
              throw 'Tried 24 times to find a valid date';
            }

            tries++;
          }

          this._setValue(this._dates[i], i);
        }
      }

      this._update();
    };

    _proto.viewDate = function viewDate(newDate) {
      if (arguments.length === 0) {
        return this._viewDate.clone();
      }

      if (!newDate) {
        this._viewDate = (this._dates[0] || this.getMoment()).clone();
        return true;
      }

      if (typeof newDate !== 'string' && !moment.isMoment(newDate) && !(newDate instanceof Date)) {
        throw new TypeError('viewDate() parameter must be one of [string, moment or Date]');
      }

      this._viewDate = this._parseInputDate(newDate);

      this._update();

      this._viewUpdate(DatePickerModes[this.currentViewMode] && DatePickerModes[this.currentViewMode].NAV_FUNCTION);
    };

    _proto._fillDate = function _fillDate() {};

    _proto._useFeatherIcons = function _useFeatherIcons() {
      return this._options.icons.type === 'feather';
    };

    _proto.allowMultidate = function allowMultidate(_allowMultidate) {
      if (typeof _allowMultidate !== 'boolean') {
        throw new TypeError('allowMultidate() expects a boolean parameter');
      }

      this._options.allowMultidate = _allowMultidate;
    };

    _proto.multidateSeparator = function multidateSeparator(_multidateSeparator) {
      if (arguments.length === 0) {
        return this._options.multidateSeparator;
      }

      if (typeof _multidateSeparator !== 'string') {
        throw new TypeError('multidateSeparator expects a string parameter');
      }

      this._options.multidateSeparator = _multidateSeparator;
    };

    _createClass(DateTimePicker, null, [{
      key: "NAME",
      get: function get() {
        return NAME;
      }
      /**
       * @return {string}
       */

    }, {
      key: "DATA_KEY",
      get: function get() {
        return DATA_KEY;
      }
      /**
       * @return {string}
       */

    }, {
      key: "EVENT_KEY",
      get: function get() {
        return EVENT_KEY;
      }
      /**
       * @return {string}
       */

    }, {
      key: "DATA_API_KEY",
      get: function get() {
        return DATA_API_KEY;
      }
    }, {
      key: "DatePickerModes",
      get: function get() {
        return DatePickerModes;
      }
    }, {
      key: "ViewModes",
      get: function get() {
        return ViewModes;
      }
    }, {
      key: "Event",
      get: function get() {
        return Event;
      }
    }, {
      key: "Selector",
      get: function get() {
        return Selector;
      }
    }, {
      key: "Default",
      get: function get() {
        return Default;
      },
      set: function set(value) {
        Default = value;
      }
    }, {
      key: "ClassName",
      get: function get() {
        return ClassName;
      }
    }]);

    return DateTimePicker;
  }();

  return DateTimePicker;
}(jQuery, moment); //noinspection JSUnusedGlobalSymbols

/* global DateTimePicker */

/* global feather */


var TempusDominusBootstrap4 = function ($) {
  // eslint-disable-line no-unused-vars
  // ReSharper disable once InconsistentNaming
  var JQUERY_NO_CONFLICT = $.fn[DateTimePicker.NAME],
      verticalModes = ['top', 'bottom', 'auto'],
      horizontalModes = ['left', 'right', 'auto'],
      toolbarPlacements = ['default', 'top', 'bottom'],
      getSelectorFromElement = function getSelectorFromElement($element) {
    var selector = $element.data('target'),
        $selector;

    if (!selector) {
      selector = $element.attr('href') || '';
      selector = /^#[a-z]/i.test(selector) ? selector : null;
    }

    $selector = $(selector);

    if ($selector.length === 0) {
      return $element;
    }

    if (!$selector.data(DateTimePicker.DATA_KEY)) {
      $.extend({}, $selector.data(), $(this).data());
    }

    return $selector;
  }; // ReSharper disable once InconsistentNaming


  var TempusDominusBootstrap4 = /*#__PURE__*/function (_DateTimePicker) {
    _inheritsLoose(TempusDominusBootstrap4, _DateTimePicker);

    function TempusDominusBootstrap4(element, options) {
      var _this;

      _this = _DateTimePicker.call(this, element, options) || this;

      _this._init();

      return _this;
    }

    var _proto2 = TempusDominusBootstrap4.prototype;

    _proto2._init = function _init() {
      if (this._element.hasClass('input-group')) {
        var datepickerButton = this._element.find('.datepickerbutton');

        if (datepickerButton.length === 0) {
          this.component = this._element.find('[data-toggle="datetimepicker"]');
        } else {
          this.component = datepickerButton;
        }
      }
    };

    _proto2._iconTag = function _iconTag(iconName) {
      if (typeof feather !== 'undefined' && this._useFeatherIcons() && feather.icons[iconName]) {
        return $('<span>').html(feather.icons[iconName].toSvg());
      } else {
        return $('<span>').addClass(iconName);
      }
    };

    _proto2._getDatePickerTemplate = function _getDatePickerTemplate() {
      var headTemplate = $('<thead>').append($('<tr>').append($('<th>').addClass('prev').attr('data-action', 'previous').append(this._iconTag(this._options.icons.previous))).append($('<th>').addClass('picker-switch').attr('data-action', 'pickerSwitch').attr('colspan', "" + (this._options.calendarWeeks ? '6' : '5'))).append($('<th>').addClass('next').attr('data-action', 'next').append(this._iconTag(this._options.icons.next)))),
          contTemplate = $('<tbody>').append($('<tr>').append($('<td>').attr('colspan', "" + (this._options.calendarWeeks ? '8' : '7'))));
      return [$('<div>').addClass('datepicker-days').append($('<table>').addClass('table table-sm').append(headTemplate).append($('<tbody>'))), $('<div>').addClass('datepicker-months').append($('<table>').addClass('table-condensed').append(headTemplate.clone()).append(contTemplate.clone())), $('<div>').addClass('datepicker-years').append($('<table>').addClass('table-condensed').append(headTemplate.clone()).append(contTemplate.clone())), $('<div>').addClass('datepicker-decades').append($('<table>').addClass('table-condensed').append(headTemplate.clone()).append(contTemplate.clone()))];
    };

    _proto2._getTimePickerMainTemplate = function _getTimePickerMainTemplate() {
      var topRow = $('<tr>'),
          middleRow = $('<tr>'),
          bottomRow = $('<tr>');

      if (this._isEnabled('h')) {
        topRow.append($('<td>').append($('<a>').attr({
          href: '#',
          tabindex: '-1',
          'title': this._options.tooltips.incrementHour
        }).addClass('btn').attr('data-action', 'incrementHours').append(this._iconTag(this._options.icons.up))));
        middleRow.append($('<td>').append($('<span>').addClass('timepicker-hour').attr({
          'data-time-component': 'hours',
          'title': this._options.tooltips.pickHour
        }).attr('data-action', 'showHours')));
        bottomRow.append($('<td>').append($('<a>').attr({
          href: '#',
          tabindex: '-1',
          'title': this._options.tooltips.decrementHour
        }).addClass('btn').attr('data-action', 'decrementHours').append(this._iconTag(this._options.icons.down))));
      }

      if (this._isEnabled('m')) {
        if (this._isEnabled('h')) {
          topRow.append($('<td>').addClass('separator'));
          middleRow.append($('<td>').addClass('separator').html(':'));
          bottomRow.append($('<td>').addClass('separator'));
        }

        topRow.append($('<td>').append($('<a>').attr({
          href: '#',
          tabindex: '-1',
          'title': this._options.tooltips.incrementMinute
        }).addClass('btn').attr('data-action', 'incrementMinutes').append(this._iconTag(this._options.icons.up))));
        middleRow.append($('<td>').append($('<span>').addClass('timepicker-minute').attr({
          'data-time-component': 'minutes',
          'title': this._options.tooltips.pickMinute
        }).attr('data-action', 'showMinutes')));
        bottomRow.append($('<td>').append($('<a>').attr({
          href: '#',
          tabindex: '-1',
          'title': this._options.tooltips.decrementMinute
        }).addClass('btn').attr('data-action', 'decrementMinutes').append(this._iconTag(this._options.icons.down))));
      }

      if (this._isEnabled('s')) {
        if (this._isEnabled('m')) {
          topRow.append($('<td>').addClass('separator'));
          middleRow.append($('<td>').addClass('separator').html(':'));
          bottomRow.append($('<td>').addClass('separator'));
        }

        topRow.append($('<td>').append($('<a>').attr({
          href: '#',
          tabindex: '-1',
          'title': this._options.tooltips.incrementSecond
        }).addClass('btn').attr('data-action', 'incrementSeconds').append(this._iconTag(this._options.icons.up))));
        middleRow.append($('<td>').append($('<span>').addClass('timepicker-second').attr({
          'data-time-component': 'seconds',
          'title': this._options.tooltips.pickSecond
        }).attr('data-action', 'showSeconds')));
        bottomRow.append($('<td>').append($('<a>').attr({
          href: '#',
          tabindex: '-1',
          'title': this._options.tooltips.decrementSecond
        }).addClass('btn').attr('data-action', 'decrementSeconds').append(this._iconTag(this._options.icons.down))));
      }

      if (!this.use24Hours) {
        topRow.append($('<td>').addClass('separator'));
        middleRow.append($('<td>').append($('<button>').addClass('btn btn-primary').attr({
          'data-action': 'togglePeriod',
          tabindex: '-1',
          'title': this._options.tooltips.togglePeriod
        })));
        bottomRow.append($('<td>').addClass('separator'));
      }

      return $('<div>').addClass('timepicker-picker').append($('<table>').addClass('table-condensed').append([topRow, middleRow, bottomRow]));
    };

    _proto2._getTimePickerTemplate = function _getTimePickerTemplate() {
      var hoursView = $('<div>').addClass('timepicker-hours').append($('<table>').addClass('table-condensed')),
          minutesView = $('<div>').addClass('timepicker-minutes').append($('<table>').addClass('table-condensed')),
          secondsView = $('<div>').addClass('timepicker-seconds').append($('<table>').addClass('table-condensed')),
          ret = [this._getTimePickerMainTemplate()];

      if (this._isEnabled('h')) {
        ret.push(hoursView);
      }

      if (this._isEnabled('m')) {
        ret.push(minutesView);
      }

      if (this._isEnabled('s')) {
        ret.push(secondsView);
      }

      return ret;
    };

    _proto2._getToolbar = function _getToolbar() {
      var row = [];

      if (this._options.buttons.showToday) {
        row.push($('<td>').append($('<a>').attr({
          href: '#',
          tabindex: '-1',
          'data-action': 'today',
          'title': this._options.tooltips.today
        }).append(this._iconTag(this._options.icons.today))));
      }

      if (!this._options.sideBySide && this._options.collapse && this._hasDate() && this._hasTime()) {
        var title, icon;

        if (this._options.viewMode === 'times') {
          title = this._options.tooltips.selectDate;
          icon = this._options.icons.date;
        } else {
          title = this._options.tooltips.selectTime;
          icon = this._options.icons.time;
        }

        row.push($('<td>').append($('<a>').attr({
          href: '#',
          tabindex: '-1',
          'data-action': 'togglePicker',
          'title': title
        }).append(this._iconTag(icon))));
      }

      if (this._options.buttons.showClear) {
        row.push($('<td>').append($('<a>').attr({
          href: '#',
          tabindex: '-1',
          'data-action': 'clear',
          'title': this._options.tooltips.clear
        }).append(this._iconTag(this._options.icons.clear))));
      }

      if (this._options.buttons.showClose) {
        row.push($('<td>').append($('<a>').attr({
          href: '#',
          tabindex: '-1',
          'data-action': 'close',
          'title': this._options.tooltips.close
        }).append(this._iconTag(this._options.icons.close))));
      }

      return row.length === 0 ? '' : $('<table>').addClass('table-condensed').append($('<tbody>').append($('<tr>').append(row)));
    };

    _proto2._getTemplate = function _getTemplate() {
      var template = $('<div>').addClass(("bootstrap-datetimepicker-widget dropdown-menu " + (this._options.calendarWeeks ? 'tempusdominus-bootstrap-datetimepicker-widget-with-calendar-weeks' : '') + " " + ((this._useFeatherIcons() ? 'tempusdominus-bootstrap-datetimepicker-widget-with-feather-icons' : '') + " ")).trim()),
          dateView = $('<div>').addClass('datepicker').append(this._getDatePickerTemplate()),
          timeView = $('<div>').addClass('timepicker').append(this._getTimePickerTemplate()),
          content = $('<ul>').addClass('list-unstyled'),
          toolbar = $('<li>').addClass(("picker-switch" + (this._options.collapse ? ' accordion-toggle' : '') + " " + ("" + (this._useFeatherIcons() ? 'picker-switch-with-feathers-icons' : ''))).trim()).append(this._getToolbar());

      if (this._options.inline) {
        template.removeClass('dropdown-menu');
      }

      if (this.use24Hours) {
        template.addClass('usetwentyfour');
      }

      if (this.input !== undefined && this.input.prop('readonly') || this._options.readonly) {
        template.addClass('bootstrap-datetimepicker-widget-readonly');
      }

      if (this._isEnabled('s') && !this.use24Hours) {
        template.addClass('wider');
      }

      if (this._options.sideBySide && this._hasDate() && this._hasTime()) {
        template.addClass('timepicker-sbs');

        if (this._options.toolbarPlacement === 'top') {
          template.append(toolbar);
        }

        template.append($('<div>').addClass('row').append(dateView.addClass('col-md-6')).append(timeView.addClass('col-md-6')));

        if (this._options.toolbarPlacement === 'bottom' || this._options.toolbarPlacement === 'default') {
          template.append(toolbar);
        }

        return template;
      }

      if (this._options.toolbarPlacement === 'top') {
        content.append(toolbar);
      }

      if (this._hasDate()) {
        content.append($('<li>').addClass(this._options.collapse && this._hasTime() ? 'collapse' : '').addClass(this._options.collapse && this._hasTime() && this._options.viewMode === 'times' ? '' : 'show').append(dateView));
      }

      if (this._options.toolbarPlacement === 'default') {
        content.append(toolbar);
      }

      if (this._hasTime()) {
        content.append($('<li>').addClass(this._options.collapse && this._hasDate() ? 'collapse' : '').addClass(this._options.collapse && this._hasDate() && this._options.viewMode === 'times' ? 'show' : '').append(timeView));
      }

      if (this._options.toolbarPlacement === 'bottom') {
        content.append(toolbar);
      }

      return template.append(content);
    };

    _proto2._place = function _place(e) {
      var self = e && e.data && e.data.picker || this,
          vertical = self._options.widgetPositioning.vertical,
          horizontal = self._options.widgetPositioning.horizontal,
          parent;
      var position = (self.component && self.component.length ? self.component : self._element).position(),
          offset = (self.component && self.component.length ? self.component : self._element).offset();

      if (self._options.widgetParent) {
        parent = self._options.widgetParent.append(self.widget);
      } else if (self._element.is('input')) {
        parent = self._element.after(self.widget).parent();
      } else if (self._options.inline) {
        parent = self._element.append(self.widget);
        return;
      } else {
        parent = self._element;

        self._element.children().first().after(self.widget);
      } // Top and bottom logic


      if (vertical === 'auto') {
        //noinspection JSValidateTypes
        if (offset.top + self.widget.height() * 1.5 >= $(window).height() + $(window).scrollTop() && self.widget.height() + self._element.outerHeight() < offset.top) {
          vertical = 'top';
        } else {
          vertical = 'bottom';
        }
      } // Left and right logic


      if (horizontal === 'auto') {
        if (parent.width() < offset.left + self.widget.outerWidth() / 2 && offset.left + self.widget.outerWidth() > $(window).width()) {
          horizontal = 'right';
        } else {
          horizontal = 'left';
        }
      }

      if (vertical === 'top') {
        self.widget.addClass('top').removeClass('bottom');
      } else {
        self.widget.addClass('bottom').removeClass('top');
      }

      if (horizontal === 'right') {
        self.widget.addClass('float-right');
      } else {
        self.widget.removeClass('float-right');
      } // find the first parent element that has a relative css positioning


      if (parent.css('position') !== 'relative') {
        parent = parent.parents().filter(function () {
          return $(this).css('position') === 'relative';
        }).first();
      }

      if (parent.length === 0) {
        throw new Error('datetimepicker component should be placed within a relative positioned container');
      }

      self.widget.css({
        top: vertical === 'top' ? 'auto' : position.top + self._element.outerHeight() + 'px',
        bottom: vertical === 'top' ? parent.outerHeight() - (parent === self._element ? 0 : position.top) + 'px' : 'auto',
        left: horizontal === 'left' ? (parent === self._element ? 0 : position.left) + 'px' : 'auto',
        right: horizontal === 'left' ? 'auto' : parent.outerWidth() - self._element.outerWidth() - (parent === self._element ? 0 : position.left) + 'px'
      });
    };

    _proto2._fillDow = function _fillDow() {
      var row = $('<tr>'),
          currentDate = this._viewDate.clone().startOf('w').startOf('d');

      if (this._options.calendarWeeks === true) {
        row.append($('<th>').addClass('cw').text('#'));
      }

      while (currentDate.isBefore(this._viewDate.clone().endOf('w'))) {
        row.append($('<th>').addClass('dow').text(currentDate.format('dd')));
        currentDate.add(1, 'd');
      }

      this.widget.find('.datepicker-days thead').append(row);
    };

    _proto2._fillMonths = function _fillMonths() {
      var spans = [],
          monthsShort = this._viewDate.clone().startOf('y').startOf('d');

      while (monthsShort.isSame(this._viewDate, 'y')) {
        spans.push($('<span>').attr('data-action', 'selectMonth').addClass('month').text(monthsShort.format('MMM')));
        monthsShort.add(1, 'M');
      }

      this.widget.find('.datepicker-months td').empty().append(spans);
    };

    _proto2._updateMonths = function _updateMonths() {
      var monthsView = this.widget.find('.datepicker-months'),
          monthsViewHeader = monthsView.find('th'),
          months = monthsView.find('tbody').find('span'),
          self = this,
          lastPickedDate = this._getLastPickedDate();

      monthsViewHeader.eq(0).find('span').attr('title', this._options.tooltips.prevYear);
      monthsViewHeader.eq(1).attr('title', this._options.tooltips.selectYear);
      monthsViewHeader.eq(2).find('span').attr('title', this._options.tooltips.nextYear);
      monthsView.find('.disabled').removeClass('disabled');

      if (!this._isValid(this._viewDate.clone().subtract(1, 'y'), 'y')) {
        monthsViewHeader.eq(0).addClass('disabled');
      }

      monthsViewHeader.eq(1).text(this._viewDate.year());

      if (!this._isValid(this._viewDate.clone().add(1, 'y'), 'y')) {
        monthsViewHeader.eq(2).addClass('disabled');
      }

      months.removeClass('active');

      if (lastPickedDate && lastPickedDate.isSame(this._viewDate, 'y') && !this.unset) {
        months.eq(lastPickedDate.month()).addClass('active');
      }

      months.each(function (index) {
        if (!self._isValid(self._viewDate.clone().month(index), 'M')) {
          $(this).addClass('disabled');
        }
      });
    };

    _proto2._getStartEndYear = function _getStartEndYear(factor, year) {
      var step = factor / 10,
          startYear = Math.floor(year / factor) * factor,
          endYear = startYear + step * 9,
          focusValue = Math.floor(year / step) * step;
      return [startYear, endYear, focusValue];
    };

    _proto2._updateYears = function _updateYears() {
      var yearsView = this.widget.find('.datepicker-years'),
          yearsViewHeader = yearsView.find('th'),
          yearCaps = this._getStartEndYear(10, this._viewDate.year()),
          startYear = this._viewDate.clone().year(yearCaps[0]),
          endYear = this._viewDate.clone().year(yearCaps[1]);

      var html = '';
      yearsViewHeader.eq(0).find('span').attr('title', this._options.tooltips.prevDecade);
      yearsViewHeader.eq(1).attr('title', this._options.tooltips.selectDecade);
      yearsViewHeader.eq(2).find('span').attr('title', this._options.tooltips.nextDecade);
      yearsView.find('.disabled').removeClass('disabled');

      if (this._options.minDate && this._options.minDate.isAfter(startYear, 'y')) {
        yearsViewHeader.eq(0).addClass('disabled');
      }

      yearsViewHeader.eq(1).text(startYear.year() + "-" + endYear.year());

      if (this._options.maxDate && this._options.maxDate.isBefore(endYear, 'y')) {
        yearsViewHeader.eq(2).addClass('disabled');
      }

      html += "<span data-action=\"selectYear\" class=\"year old" + (!this._isValid(startYear, 'y') ? ' disabled' : '') + "\">" + (startYear.year() - 1) + "</span>";

      while (!startYear.isAfter(endYear, 'y')) {
        html += "<span data-action=\"selectYear\" class=\"year" + (startYear.isSame(this._getLastPickedDate(), 'y') && !this.unset ? ' active' : '') + (!this._isValid(startYear, 'y') ? ' disabled' : '') + "\">" + startYear.year() + "</span>";
        startYear.add(1, 'y');
      }

      html += "<span data-action=\"selectYear\" class=\"year old" + (!this._isValid(startYear, 'y') ? ' disabled' : '') + "\">" + startYear.year() + "</span>";
      yearsView.find('td').html(html);
    };

    _proto2._updateDecades = function _updateDecades() {
      var decadesView = this.widget.find('.datepicker-decades'),
          decadesViewHeader = decadesView.find('th'),
          yearCaps = this._getStartEndYear(100, this._viewDate.year()),
          startDecade = this._viewDate.clone().year(yearCaps[0]),
          endDecade = this._viewDate.clone().year(yearCaps[1]),
          lastPickedDate = this._getLastPickedDate();

      var minDateDecade = false,
          maxDateDecade = false,
          endDecadeYear,
          html = '';
      decadesViewHeader.eq(0).find('span').attr('title', this._options.tooltips.prevCentury);
      decadesViewHeader.eq(2).find('span').attr('title', this._options.tooltips.nextCentury);
      decadesView.find('.disabled').removeClass('disabled');

      if (startDecade.year() === 0 || this._options.minDate && this._options.minDate.isAfter(startDecade, 'y')) {
        decadesViewHeader.eq(0).addClass('disabled');
      }

      decadesViewHeader.eq(1).text(startDecade.year() + "-" + endDecade.year());

      if (this._options.maxDate && this._options.maxDate.isBefore(endDecade, 'y')) {
        decadesViewHeader.eq(2).addClass('disabled');
      }

      if (startDecade.year() - 10 < 0) {
        html += '<span>&nbsp;</span>';
      } else {
        html += "<span data-action=\"selectDecade\" class=\"decade old\" data-selection=\"" + (startDecade.year() + 6) + "\">" + (startDecade.year() - 10) + "</span>";
      }

      while (!startDecade.isAfter(endDecade, 'y')) {
        endDecadeYear = startDecade.year() + 11;
        minDateDecade = this._options.minDate && this._options.minDate.isAfter(startDecade, 'y') && this._options.minDate.year() <= endDecadeYear;
        maxDateDecade = this._options.maxDate && this._options.maxDate.isAfter(startDecade, 'y') && this._options.maxDate.year() <= endDecadeYear;
        html += "<span data-action=\"selectDecade\" class=\"decade" + (lastPickedDate && lastPickedDate.isAfter(startDecade) && lastPickedDate.year() <= endDecadeYear ? ' active' : '') + (!this._isValid(startDecade, 'y') && !minDateDecade && !maxDateDecade ? ' disabled' : '') + "\" data-selection=\"" + (startDecade.year() + 6) + "\">" + startDecade.year() + "</span>";
        startDecade.add(10, 'y');
      }

      html += "<span data-action=\"selectDecade\" class=\"decade old\" data-selection=\"" + (startDecade.year() + 6) + "\">" + startDecade.year() + "</span>";
      decadesView.find('td').html(html);
    };

    _proto2._fillDate = function _fillDate() {
      _DateTimePicker.prototype._fillDate.call(this);

      var daysView = this.widget.find('.datepicker-days'),
          daysViewHeader = daysView.find('th'),
          html = [];
      var currentDate, row, clsName, i;

      if (!this._hasDate()) {
        return;
      }

      daysViewHeader.eq(0).find('span').attr('title', this._options.tooltips.prevMonth);
      daysViewHeader.eq(1).attr('title', this._options.tooltips.selectMonth);
      daysViewHeader.eq(2).find('span').attr('title', this._options.tooltips.nextMonth);
      daysView.find('.disabled').removeClass('disabled');
      daysViewHeader.eq(1).text(this._viewDate.format(this._options.dayViewHeaderFormat));

      if (!this._isValid(this._viewDate.clone().subtract(1, 'M'), 'M')) {
        daysViewHeader.eq(0).addClass('disabled');
      }

      if (!this._isValid(this._viewDate.clone().add(1, 'M'), 'M')) {
        daysViewHeader.eq(2).addClass('disabled');
      }

      currentDate = this._viewDate.clone().startOf('M').startOf('w').startOf('d');

      for (i = 0; i < 42; i++) {
        //always display 42 days (should show 6 weeks)
        if (currentDate.weekday() === 0) {
          row = $('<tr>');

          if (this._options.calendarWeeks) {
            row.append("<td class=\"cw\">" + currentDate.week() + "</td>");
          }

          html.push(row);
        }

        clsName = '';

        if (currentDate.isBefore(this._viewDate, 'M')) {
          clsName += ' old';
        }

        if (currentDate.isAfter(this._viewDate, 'M')) {
          clsName += ' new';
        }

        if (this._options.allowMultidate) {
          var index = this._datesFormatted.indexOf(currentDate.format('YYYY-MM-DD'));

          if (index !== -1) {
            if (currentDate.isSame(this._datesFormatted[index], 'd') && !this.unset) {
              clsName += ' active';
            }
          }
        } else {
          if (currentDate.isSame(this._getLastPickedDate(), 'd') && !this.unset) {
            clsName += ' active';
          }
        }

        if (!this._isValid(currentDate, 'd')) {
          clsName += ' disabled';
        }

        if (currentDate.isSame(this.getMoment(), 'd')) {
          clsName += ' today';
        }

        if (currentDate.day() === 0 || currentDate.day() === 6) {
          clsName += ' weekend';
        }

        row.append("<td data-action=\"selectDay\" data-day=\"" + currentDate.format('L') + "\" class=\"day" + clsName + "\">" + currentDate.date() + "</td>");
        currentDate.add(1, 'd');
      }

      $('body').addClass('tempusdominus-bootstrap-datetimepicker-widget-day-click');
      $('body').append('<div class="tempusdominus-bootstrap-datetimepicker-widget-day-click-glass-panel"></div>');
      daysView.find('tbody').empty().append(html);
      $('body').find('.tempusdominus-bootstrap-datetimepicker-widget-day-click-glass-panel').remove();
      $('body').removeClass('tempusdominus-bootstrap-datetimepicker-widget-day-click');

      this._updateMonths();

      this._updateYears();

      this._updateDecades();
    };

    _proto2._fillHours = function _fillHours() {
      var table = this.widget.find('.timepicker-hours table'),
          currentHour = this._viewDate.clone().startOf('d'),
          html = [];

      var row = $('<tr>');

      if (this._viewDate.hour() > 11 && !this.use24Hours) {
        currentHour.hour(12);
      }

      while (currentHour.isSame(this._viewDate, 'd') && (this.use24Hours || this._viewDate.hour() < 12 && currentHour.hour() < 12 || this._viewDate.hour() > 11)) {
        if (currentHour.hour() % 4 === 0) {
          row = $('<tr>');
          html.push(row);
        }

        row.append("<td data-action=\"selectHour\" class=\"hour" + (!this._isValid(currentHour, 'h') ? ' disabled' : '') + "\">" + currentHour.format(this.use24Hours ? 'HH' : 'hh') + "</td>");
        currentHour.add(1, 'h');
      }

      table.empty().append(html);
    };

    _proto2._fillMinutes = function _fillMinutes() {
      var table = this.widget.find('.timepicker-minutes table'),
          currentMinute = this._viewDate.clone().startOf('h'),
          html = [],
          step = this._options.stepping === 1 ? 5 : this._options.stepping;

      var row = $('<tr>');

      while (this._viewDate.isSame(currentMinute, 'h')) {
        if (currentMinute.minute() % (step * 4) === 0) {
          row = $('<tr>');
          html.push(row);
        }

        row.append("<td data-action=\"selectMinute\" class=\"minute" + (!this._isValid(currentMinute, 'm') ? ' disabled' : '') + "\">" + currentMinute.format('mm') + "</td>");
        currentMinute.add(step, 'm');
      }

      table.empty().append(html);
    };

    _proto2._fillSeconds = function _fillSeconds() {
      var table = this.widget.find('.timepicker-seconds table'),
          currentSecond = this._viewDate.clone().startOf('m'),
          html = [];

      var row = $('<tr>');

      while (this._viewDate.isSame(currentSecond, 'm')) {
        if (currentSecond.second() % 20 === 0) {
          row = $('<tr>');
          html.push(row);
        }

        row.append("<td data-action=\"selectSecond\" class=\"second" + (!this._isValid(currentSecond, 's') ? ' disabled' : '') + "\">" + currentSecond.format('ss') + "</td>");
        currentSecond.add(5, 's');
      }

      table.empty().append(html);
    };

    _proto2._fillTime = function _fillTime() {
      var toggle, newDate;

      var timeComponents = this.widget.find('.timepicker span[data-time-component]'),
          lastPickedDate = this._getLastPickedDate();

      if (!this.use24Hours) {
        toggle = this.widget.find('.timepicker [data-action=togglePeriod]');
        newDate = lastPickedDate ? lastPickedDate.clone().add(lastPickedDate.hours() >= 12 ? -12 : 12, 'h') : void 0;
        lastPickedDate && toggle.text(lastPickedDate.format('A'));

        if (this._isValid(newDate, 'h')) {
          toggle.removeClass('disabled');
        } else {
          toggle.addClass('disabled');
        }
      }

      lastPickedDate && timeComponents.filter('[data-time-component=hours]').text(lastPickedDate.format("" + (this.use24Hours ? 'HH' : 'hh')));
      lastPickedDate && timeComponents.filter('[data-time-component=minutes]').text(lastPickedDate.format('mm'));
      lastPickedDate && timeComponents.filter('[data-time-component=seconds]').text(lastPickedDate.format('ss'));

      this._fillHours();

      this._fillMinutes();

      this._fillSeconds();
    };

    _proto2._doAction = function _doAction(e, action) {
      var lastPicked = this._getLastPickedDate();

      if ($(e.currentTarget).is('.disabled')) {
        return false;
      }

      action = action || $(e.currentTarget).data('action');

      switch (action) {
        case 'next':
          {
            var navFnc = DateTimePicker.DatePickerModes[this.currentViewMode].NAV_FUNCTION;

            this._viewDate.add(DateTimePicker.DatePickerModes[this.currentViewMode].NAV_STEP, navFnc);

            this._fillDate();

            this._viewUpdate(navFnc);

            break;
          }

        case 'previous':
          {
            var _navFnc = DateTimePicker.DatePickerModes[this.currentViewMode].NAV_FUNCTION;

            this._viewDate.subtract(DateTimePicker.DatePickerModes[this.currentViewMode].NAV_STEP, _navFnc);

            this._fillDate();

            this._viewUpdate(_navFnc);

            break;
          }

        case 'pickerSwitch':
          this._showMode(1);

          break;

        case 'selectMonth':
          {
            var month = $(e.target).closest('tbody').find('span').index($(e.target));

            this._viewDate.month(month);

            if (this.currentViewMode === this.MinViewModeNumber) {
              this._setValue(lastPicked.clone().year(this._viewDate.year()).month(this._viewDate.month()), this._getLastPickedDateIndex());

              if (!this._options.inline) {
                this.hide();
              }
            } else {
              this._showMode(-1);

              this._fillDate();
            }

            this._viewUpdate('M');

            break;
          }

        case 'selectYear':
          {
            var year = parseInt($(e.target).text(), 10) || 0;

            this._viewDate.year(year);

            if (this.currentViewMode === this.MinViewModeNumber) {
              this._setValue(lastPicked.clone().year(this._viewDate.year()), this._getLastPickedDateIndex());

              if (!this._options.inline) {
                this.hide();
              }
            } else {
              this._showMode(-1);

              this._fillDate();
            }

            this._viewUpdate('YYYY');

            break;
          }

        case 'selectDecade':
          {
            var _year = parseInt($(e.target).data('selection'), 10) || 0;

            this._viewDate.year(_year);

            if (this.currentViewMode === this.MinViewModeNumber) {
              this._setValue(lastPicked.clone().year(this._viewDate.year()), this._getLastPickedDateIndex());

              if (!this._options.inline) {
                this.hide();
              }
            } else {
              this._showMode(-1);

              this._fillDate();
            }

            this._viewUpdate('YYYY');

            break;
          }

        case 'selectDay':
          {
            var day = this._viewDate.clone();

            if ($(e.target).is('.old')) {
              day.subtract(1, 'M');
            }

            if ($(e.target).is('.new')) {
              day.add(1, 'M');
            }

            var selectDate = day.date(parseInt($(e.target).text(), 10)),
                index = 0;

            if (this._options.allowMultidate) {
              index = this._datesFormatted.indexOf(selectDate.format('YYYY-MM-DD'));

              if (index !== -1) {
                this._setValue(null, index); //deselect multidate

              } else {
                this._setValue(selectDate, this._getLastPickedDateIndex() + 1);
              }
            } else {
              this._setValue(selectDate, this._getLastPickedDateIndex());
            }

            if (!this._hasTime() && !this._options.keepOpen && !this._options.inline && !this._options.allowMultidate) {
              this.hide();
            }

            break;
          }

        case 'incrementHours':
          {
            if (!lastPicked) {
              break;
            }

            var newDate = lastPicked.clone().add(1, 'h');

            if (this._isValid(newDate, 'h')) {
              if (this._getLastPickedDateIndex() < 0) {
                this.date(newDate);
              }

              this._setValue(newDate, this._getLastPickedDateIndex());
            }

            break;
          }

        case 'incrementMinutes':
          {
            if (!lastPicked) {
              break;
            }

            var _newDate = lastPicked.clone().add(this._options.stepping, 'm');

            if (this._isValid(_newDate, 'm')) {
              if (this._getLastPickedDateIndex() < 0) {
                this.date(_newDate);
              }

              this._setValue(_newDate, this._getLastPickedDateIndex());
            }

            break;
          }

        case 'incrementSeconds':
          {
            if (!lastPicked) {
              break;
            }

            var _newDate2 = lastPicked.clone().add(1, 's');

            if (this._isValid(_newDate2, 's')) {
              if (this._getLastPickedDateIndex() < 0) {
                this.date(_newDate2);
              }

              this._setValue(_newDate2, this._getLastPickedDateIndex());
            }

            break;
          }

        case 'decrementHours':
          {
            if (!lastPicked) {
              break;
            }

            var _newDate3 = lastPicked.clone().subtract(1, 'h');

            if (this._isValid(_newDate3, 'h')) {
              if (this._getLastPickedDateIndex() < 0) {
                this.date(_newDate3);
              }

              this._setValue(_newDate3, this._getLastPickedDateIndex());
            }

            break;
          }

        case 'decrementMinutes':
          {
            if (!lastPicked) {
              break;
            }

            var _newDate4 = lastPicked.clone().subtract(this._options.stepping, 'm');

            if (this._isValid(_newDate4, 'm')) {
              if (this._getLastPickedDateIndex() < 0) {
                this.date(_newDate4);
              }

              this._setValue(_newDate4, this._getLastPickedDateIndex());
            }

            break;
          }

        case 'decrementSeconds':
          {
            if (!lastPicked) {
              break;
            }

            var _newDate5 = lastPicked.clone().subtract(1, 's');

            if (this._isValid(_newDate5, 's')) {
              if (this._getLastPickedDateIndex() < 0) {
                this.date(_newDate5);
              }

              this._setValue(_newDate5, this._getLastPickedDateIndex());
            }

            break;
          }

        case 'togglePeriod':
          {
            this._setValue(lastPicked.clone().add(lastPicked.hours() >= 12 ? -12 : 12, 'h'), this._getLastPickedDateIndex());

            break;
          }

        case 'togglePicker':
          {
            var $this = $(e.target),
                $link = $this.closest('a'),
                $parent = $this.closest('ul'),
                expanded = $parent.find('.show'),
                closed = $parent.find('.collapse:not(.show)'),
                $span = $this.is('span') ? $this : $this.find('span');
            var collapseData, inactiveIcon, iconTest;

            if (expanded && expanded.length) {
              collapseData = expanded.data('collapse');

              if (collapseData && collapseData.transitioning) {
                return true;
              }

              if (expanded.collapse) {
                // if collapse plugin is available through bootstrap.js then use it
                expanded.collapse('hide');
                closed.collapse('show');
              } else {
                // otherwise just toggle in class on the two views
                expanded.removeClass('show');
                closed.addClass('show');
              }

              if (this._useFeatherIcons()) {
                $link.toggleClass(this._options.icons.time + ' ' + this._options.icons.date);
                inactiveIcon = $link.hasClass(this._options.icons.time) ? this._options.icons.date : this._options.icons.time;
                $link.html(this._iconTag(inactiveIcon));
              } else {
                $span.toggleClass(this._options.icons.time + ' ' + this._options.icons.date);
              }

              if (this._useFeatherIcons()) {
                iconTest = $link.hasClass(this._options.icons.date);
              } else {
                iconTest = $span.hasClass(this._options.icons.date);
              }

              if (iconTest) {
                $link.attr('title', this._options.tooltips.selectDate);
              } else {
                $link.attr('title', this._options.tooltips.selectTime);
              }
            }
          }
          break;

        case 'showPicker':
          this.widget.find('.timepicker > div:not(.timepicker-picker)').hide();
          this.widget.find('.timepicker .timepicker-picker').show();
          break;

        case 'showHours':
          this.widget.find('.timepicker .timepicker-picker').hide();
          this.widget.find('.timepicker .timepicker-hours').show();
          break;

        case 'showMinutes':
          this.widget.find('.timepicker .timepicker-picker').hide();
          this.widget.find('.timepicker .timepicker-minutes').show();
          break;

        case 'showSeconds':
          this.widget.find('.timepicker .timepicker-picker').hide();
          this.widget.find('.timepicker .timepicker-seconds').show();
          break;

        case 'selectHour':
          {
            var hour = parseInt($(e.target).text(), 10);

            if (!this.use24Hours) {
              if (lastPicked.hours() >= 12) {
                if (hour !== 12) {
                  hour += 12;
                }
              } else {
                if (hour === 12) {
                  hour = 0;
                }
              }
            }

            this._setValue(lastPicked.clone().hours(hour), this._getLastPickedDateIndex());

            if (!this._isEnabled('a') && !this._isEnabled('m') && !this._options.keepOpen && !this._options.inline) {
              this.hide();
            } else {
              this._doAction(e, 'showPicker');
            }

            break;
          }

        case 'selectMinute':
          this._setValue(lastPicked.clone().minutes(parseInt($(e.target).text(), 10)), this._getLastPickedDateIndex());

          if (!this._isEnabled('a') && !this._isEnabled('s') && !this._options.keepOpen && !this._options.inline) {
            this.hide();
          } else {
            this._doAction(e, 'showPicker');
          }

          break;

        case 'selectSecond':
          this._setValue(lastPicked.clone().seconds(parseInt($(e.target).text(), 10)), this._getLastPickedDateIndex());

          if (!this._isEnabled('a') && !this._options.keepOpen && !this._options.inline) {
            this.hide();
          } else {
            this._doAction(e, 'showPicker');
          }

          break;

        case 'clear':
          this.clear();
          break;

        case 'close':
          this.hide();
          break;

        case 'today':
          {
            var todaysDate = this.getMoment();

            if (this._isValid(todaysDate, 'd')) {
              this._setValue(todaysDate, this._getLastPickedDateIndex());
            }

            break;
          }
      }

      return false;
    } //public
    ;

    _proto2.hide = function hide() {
      var transitioning = false;

      if (!this.widget) {
        return;
      } // Ignore event if in the middle of a picker transition


      this.widget.find('.collapse').each(function () {
        var collapseData = $(this).data('collapse');

        if (collapseData && collapseData.transitioning) {
          transitioning = true;
          return false;
        }

        return true;
      });

      if (transitioning) {
        return;
      }

      if (this.component && this.component.hasClass('btn')) {
        this.component.toggleClass('active');
      }

      this.widget.hide();
      $(window).off('resize', this._place);
      this.widget.off('click', '[data-action]');
      this.widget.off('mousedown', false);
      this.widget.remove();
      this.widget = false;

      if (this.input !== undefined && this.input.val() !== undefined && this.input.val().trim().length !== 0) {
        this._setValue(this._parseInputDate(this.input.val().trim(), {
          isPickerShow: false
        }), 0);
      }

      var lastPickedDate = this._getLastPickedDate();

      this._notifyEvent({
        type: DateTimePicker.Event.HIDE,
        date: this.unset ? null : lastPickedDate ? lastPickedDate.clone() : void 0
      });

      if (this.input !== undefined) {
        this.input.blur();
      }

      this._viewDate = lastPickedDate ? lastPickedDate.clone() : this.getMoment();
    };

    _proto2.show = function show() {
      var currentMoment,
          shouldUseCurrentIfUnset = false;
      var useCurrentGranularity = {
        'year': function year(m) {
          return m.month(0).date(1).hours(0).seconds(0).minutes(0);
        },
        'month': function month(m) {
          return m.date(1).hours(0).seconds(0).minutes(0);
        },
        'day': function day(m) {
          return m.hours(0).seconds(0).minutes(0);
        },
        'hour': function hour(m) {
          return m.seconds(0).minutes(0);
        },
        'minute': function minute(m) {
          return m.seconds(0);
        }
      };

      if (this.input !== undefined) {
        if (this.input.prop('disabled') || !this._options.ignoreReadonly && this.input.prop('readonly') || this.widget) {
          return;
        }

        if (this.input.val() !== undefined && this.input.val().trim().length !== 0) {
          this._setValue(this._parseInputDate(this.input.val().trim(), {
            isPickerShow: true
          }), 0);
        } else {
          shouldUseCurrentIfUnset = true;
        }
      } else {
        shouldUseCurrentIfUnset = true;
      }

      if (shouldUseCurrentIfUnset && this.unset && this._options.useCurrent) {
        currentMoment = this.getMoment();

        if (typeof this._options.useCurrent === 'string') {
          currentMoment = useCurrentGranularity[this._options.useCurrent](currentMoment);
        }

        this._setValue(currentMoment, 0);
      }

      this.widget = this._getTemplate();

      this._fillDow();

      this._fillMonths();

      this.widget.find('.timepicker-hours').hide();
      this.widget.find('.timepicker-minutes').hide();
      this.widget.find('.timepicker-seconds').hide();

      this._update();

      this._showMode();

      $(window).on('resize', {
        picker: this
      }, this._place);
      this.widget.on('click', '[data-action]', $.proxy(this._doAction, this)); // this handles clicks on the widget

      this.widget.on('mousedown', false);

      if (this.component && this.component.hasClass('btn')) {
        this.component.toggleClass('active');
      }

      this._place();

      this.widget.show();

      if (this.input !== undefined && this._options.focusOnShow && !this.input.is(':focus')) {
        this.input.focus();
      }

      this._notifyEvent({
        type: DateTimePicker.Event.SHOW
      });
    };

    _proto2.destroy = function destroy() {
      this.hide(); //todo doc off?

      this._element.removeData(DateTimePicker.DATA_KEY);

      this._element.removeData('date');
    };

    _proto2.disable = function disable() {
      this.hide();

      if (this.component && this.component.hasClass('btn')) {
        this.component.addClass('disabled');
      }

      if (this.input !== undefined) {
        this.input.prop('disabled', true); //todo disable this/comp if input is null
      }
    };

    _proto2.enable = function enable() {
      if (this.component && this.component.hasClass('btn')) {
        this.component.removeClass('disabled');
      }

      if (this.input !== undefined) {
        this.input.prop('disabled', false); //todo enable comp/this if input is null
      }
    };

    _proto2.toolbarPlacement = function toolbarPlacement(_toolbarPlacement) {
      if (arguments.length === 0) {
        return this._options.toolbarPlacement;
      }

      if (typeof _toolbarPlacement !== 'string') {
        throw new TypeError('toolbarPlacement() expects a string parameter');
      }

      if (toolbarPlacements.indexOf(_toolbarPlacement) === -1) {
        throw new TypeError("toolbarPlacement() parameter must be one of (" + toolbarPlacements.join(', ') + ") value");
      }

      this._options.toolbarPlacement = _toolbarPlacement;

      if (this.widget) {
        this.hide();
        this.show();
      }
    };

    _proto2.widgetPositioning = function widgetPositioning(_widgetPositioning) {
      if (arguments.length === 0) {
        return $.extend({}, this._options.widgetPositioning);
      }

      if ({}.toString.call(_widgetPositioning) !== '[object Object]') {
        throw new TypeError('widgetPositioning() expects an object variable');
      }

      if (_widgetPositioning.horizontal) {
        if (typeof _widgetPositioning.horizontal !== 'string') {
          throw new TypeError('widgetPositioning() horizontal variable must be a string');
        }

        _widgetPositioning.horizontal = _widgetPositioning.horizontal.toLowerCase();

        if (horizontalModes.indexOf(_widgetPositioning.horizontal) === -1) {
          throw new TypeError("widgetPositioning() expects horizontal parameter to be one of (" + horizontalModes.join(', ') + ")");
        }

        this._options.widgetPositioning.horizontal = _widgetPositioning.horizontal;
      }

      if (_widgetPositioning.vertical) {
        if (typeof _widgetPositioning.vertical !== 'string') {
          throw new TypeError('widgetPositioning() vertical variable must be a string');
        }

        _widgetPositioning.vertical = _widgetPositioning.vertical.toLowerCase();

        if (verticalModes.indexOf(_widgetPositioning.vertical) === -1) {
          throw new TypeError("widgetPositioning() expects vertical parameter to be one of (" + verticalModes.join(', ') + ")");
        }

        this._options.widgetPositioning.vertical = _widgetPositioning.vertical;
      }

      this._update();
    };

    _proto2.widgetParent = function widgetParent(_widgetParent) {
      if (arguments.length === 0) {
        return this._options.widgetParent;
      }

      if (typeof _widgetParent === 'string') {
        _widgetParent = $(_widgetParent);
      }

      if (_widgetParent !== null && typeof _widgetParent !== 'string' && !(_widgetParent instanceof $)) {
        throw new TypeError('widgetParent() expects a string or a jQuery object parameter');
      }

      this._options.widgetParent = _widgetParent;

      if (this.widget) {
        this.hide();
        this.show();
      }
    };

    _proto2.setMultiDate = function setMultiDate(multiDateArray) {
      var dateFormat = this._options.format;
      this.clear();

      for (var index = 0; index < multiDateArray.length; index++) {
        var date = moment(multiDateArray[index], dateFormat);

        this._setValue(date, index);
      }
    } //static
    ;

    TempusDominusBootstrap4._jQueryHandleThis = function _jQueryHandleThis(me, option, argument) {
      var data = $(me).data(DateTimePicker.DATA_KEY);

      if (typeof option === 'object') {
        $.extend({}, DateTimePicker.Default, option);
      }

      if (!data) {
        data = new TempusDominusBootstrap4($(me), option);
        $(me).data(DateTimePicker.DATA_KEY, data);
      }

      if (typeof option === 'string') {
        if (data[option] === undefined) {
          throw new Error("No method named \"" + option + "\"");
        }

        if (argument === undefined) {
          return data[option]();
        } else {
          if (option === 'date') {
            data.isDateUpdateThroughDateOptionFromClientCode = true;
          }

          var ret = data[option](argument);
          data.isDateUpdateThroughDateOptionFromClientCode = false;
          return ret;
        }
      }
    };

    TempusDominusBootstrap4._jQueryInterface = function _jQueryInterface(option, argument) {
      if (this.length === 1) {
        return TempusDominusBootstrap4._jQueryHandleThis(this[0], option, argument);
      }

      return this.each(function () {
        TempusDominusBootstrap4._jQueryHandleThis(this, option, argument);
      });
    };

    return TempusDominusBootstrap4;
  }(DateTimePicker);
  /**
  * ------------------------------------------------------------------------
  * jQuery
  * ------------------------------------------------------------------------
  */


  $(document).on(DateTimePicker.Event.CLICK_DATA_API, DateTimePicker.Selector.DATA_TOGGLE, function () {
    var $originalTarget = $(this),
        $target = getSelectorFromElement($originalTarget),
        config = $target.data(DateTimePicker.DATA_KEY);

    if ($target.length === 0) {
      return;
    }

    if (config._options.allowInputToggle && $originalTarget.is('input[data-toggle="datetimepicker"]')) {
      return;
    }

    TempusDominusBootstrap4._jQueryInterface.call($target, 'toggle');
  }).on(DateTimePicker.Event.CHANGE, "." + DateTimePicker.ClassName.INPUT, function (event) {
    var $target = getSelectorFromElement($(this));

    if ($target.length === 0 || event.isInit) {
      return;
    }

    TempusDominusBootstrap4._jQueryInterface.call($target, '_change', event);
  }).on(DateTimePicker.Event.BLUR, "." + DateTimePicker.ClassName.INPUT, function (event) {
    var $target = getSelectorFromElement($(this)),
        config = $target.data(DateTimePicker.DATA_KEY);

    if ($target.length === 0) {
      return;
    }

    if (config._options.debug || window.debug) {
      return;
    }

    TempusDominusBootstrap4._jQueryInterface.call($target, 'hide', event);
  }).on(DateTimePicker.Event.KEYDOWN, "." + DateTimePicker.ClassName.INPUT, function (event) {
    var $target = getSelectorFromElement($(this));

    if ($target.length === 0) {
      return;
    }

    TempusDominusBootstrap4._jQueryInterface.call($target, '_keydown', event);
  }).on(DateTimePicker.Event.KEYUP, "." + DateTimePicker.ClassName.INPUT, function (event) {
    var $target = getSelectorFromElement($(this));

    if ($target.length === 0) {
      return;
    }

    TempusDominusBootstrap4._jQueryInterface.call($target, '_keyup', event);
  }).on(DateTimePicker.Event.FOCUS, "." + DateTimePicker.ClassName.INPUT, function (event) {
    var $target = getSelectorFromElement($(this)),
        config = $target.data(DateTimePicker.DATA_KEY);

    if ($target.length === 0) {
      return;
    }

    if (!config._options.allowInputToggle) {
      return;
    }

    TempusDominusBootstrap4._jQueryInterface.call($target, 'show', event);
  });
  $.fn[DateTimePicker.NAME] = TempusDominusBootstrap4._jQueryInterface;
  $.fn[DateTimePicker.NAME].Constructor = TempusDominusBootstrap4;

  $.fn[DateTimePicker.NAME].noConflict = function () {
    $.fn[DateTimePicker.NAME] = JQUERY_NO_CONFLICT;
    return TempusDominusBootstrap4._jQueryInterface;
  };

  return TempusDominusBootstrap4;
}(jQuery);

}();

$.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
    icons: {
        time: 'ki ki-clock',
        date: 'ki ki-calendar',
        up: 'ki ki-arrow-up',
        down: 'ki ki-arrow-down',
        previous: 'ki ki-arrow-back',
        next: 'ki ki-arrow-next',
        today: 'ki ki-calendar-today',
        clear: 'ki ki-close',
        close: 'ki ki-close'
    }
});

/*! bootstrap-timepicker v0.5.2 
* http://jdewit.github.com/bootstrap-timepicker 
* Copyright (c) 2016 Joris de Wit and bootstrap-timepicker contributors 
* MIT License 
*/!function(a,b,c){"use strict";var d=function(b,c){this.widget="",this.$element=a(b),this.defaultTime=c.defaultTime,this.disableFocus=c.disableFocus,this.disableMousewheel=c.disableMousewheel,this.isOpen=c.isOpen,this.minuteStep=c.minuteStep,this.modalBackdrop=c.modalBackdrop,this.orientation=c.orientation,this.secondStep=c.secondStep,this.snapToStep=c.snapToStep,this.showInputs=c.showInputs,this.showMeridian=c.showMeridian,this.showSeconds=c.showSeconds,this.template=c.template,this.appendWidgetTo=c.appendWidgetTo,this.showWidgetOnAddonClick=c.showWidgetOnAddonClick,this.icons=c.icons,this.maxHours=c.maxHours,this.explicitMode=c.explicitMode,this.handleDocumentClick=function(a){var b=a.data.scope;b.$element.parent().find(a.target).length||b.$widget.is(a.target)||b.$widget.find(a.target).length||b.hideWidget()},this._init()};d.prototype={constructor:d,_init:function(){var b=this;this.showWidgetOnAddonClick&&this.$element.parent().hasClass("input-group")&&this.$element.parent().hasClass("bootstrap-timepicker")?(this.$element.parent(".input-group.bootstrap-timepicker").find(".input-group-addon").on({"click.timepicker":a.proxy(this.showWidget,this)}),this.$element.on({"focus.timepicker":a.proxy(this.highlightUnit,this),"click.timepicker":a.proxy(this.highlightUnit,this),"keydown.timepicker":a.proxy(this.elementKeydown,this),"blur.timepicker":a.proxy(this.blurElement,this),"mousewheel.timepicker DOMMouseScroll.timepicker":a.proxy(this.mousewheel,this)})):this.template?this.$element.on({"focus.timepicker":a.proxy(this.showWidget,this),"click.timepicker":a.proxy(this.showWidget,this),"blur.timepicker":a.proxy(this.blurElement,this),"mousewheel.timepicker DOMMouseScroll.timepicker":a.proxy(this.mousewheel,this)}):this.$element.on({"focus.timepicker":a.proxy(this.highlightUnit,this),"click.timepicker":a.proxy(this.highlightUnit,this),"keydown.timepicker":a.proxy(this.elementKeydown,this),"blur.timepicker":a.proxy(this.blurElement,this),"mousewheel.timepicker DOMMouseScroll.timepicker":a.proxy(this.mousewheel,this)}),this.template!==!1?this.$widget=a(this.getTemplate()).on("click",a.proxy(this.widgetClick,this)):this.$widget=!1,this.showInputs&&this.$widget!==!1&&this.$widget.find("input").each(function(){a(this).on({"click.timepicker":function(){a(this).select()},"keydown.timepicker":a.proxy(b.widgetKeydown,b),"keyup.timepicker":a.proxy(b.widgetKeyup,b)})}),this.setDefaultTime(this.defaultTime)},blurElement:function(){this.highlightedUnit=null,this.updateFromElementVal()},clear:function(){this.hour="",this.minute="",this.second="",this.meridian="",this.$element.val("")},decrementHour:function(){if(this.showMeridian)if(1===this.hour)this.hour=12;else{if(12===this.hour)return this.hour--,this.toggleMeridian();if(0===this.hour)return this.hour=11,this.toggleMeridian();this.hour--}else this.hour<=0?this.hour=this.maxHours-1:this.hour--},decrementMinute:function(a){var b;b=a?this.minute-a:this.minute-this.minuteStep,0>b?(this.decrementHour(),this.minute=b+60):this.minute=b},decrementSecond:function(){var a=this.second-this.secondStep;0>a?(this.decrementMinute(!0),this.second=a+60):this.second=a},elementKeydown:function(a){switch(a.which){case 9:if(a.shiftKey){if("hour"===this.highlightedUnit){this.hideWidget();break}this.highlightPrevUnit()}else{if(this.showMeridian&&"meridian"===this.highlightedUnit||this.showSeconds&&"second"===this.highlightedUnit||!this.showMeridian&&!this.showSeconds&&"minute"===this.highlightedUnit){this.hideWidget();break}this.highlightNextUnit()}a.preventDefault(),this.updateFromElementVal();break;case 27:this.updateFromElementVal();break;case 37:a.preventDefault(),this.highlightPrevUnit(),this.updateFromElementVal();break;case 38:switch(a.preventDefault(),this.highlightedUnit){case"hour":this.incrementHour(),this.highlightHour();break;case"minute":this.incrementMinute(),this.highlightMinute();break;case"second":this.incrementSecond(),this.highlightSecond();break;case"meridian":this.toggleMeridian(),this.highlightMeridian()}this.update();break;case 39:a.preventDefault(),this.highlightNextUnit(),this.updateFromElementVal();break;case 40:switch(a.preventDefault(),this.highlightedUnit){case"hour":this.decrementHour(),this.highlightHour();break;case"minute":this.decrementMinute(),this.highlightMinute();break;case"second":this.decrementSecond(),this.highlightSecond();break;case"meridian":this.toggleMeridian(),this.highlightMeridian()}this.update()}},getCursorPosition:function(){var a=this.$element.get(0);if("selectionStart"in a)return a.selectionStart;if(c.selection){a.focus();var b=c.selection.createRange(),d=c.selection.createRange().text.length;return b.moveStart("character",-a.value.length),b.text.length-d}},getTemplate:function(){var a,b,c,d,e,f;switch(this.showInputs?(b='<input type="text" class="bootstrap-timepicker-hour" maxlength="2"/>',c='<input type="text" class="bootstrap-timepicker-minute" maxlength="2"/>',d='<input type="text" class="bootstrap-timepicker-second" maxlength="2"/>',e='<input type="text" class="bootstrap-timepicker-meridian" maxlength="2"/>'):(b='<span class="bootstrap-timepicker-hour"></span>',c='<span class="bootstrap-timepicker-minute"></span>',d='<span class="bootstrap-timepicker-second"></span>',e='<span class="bootstrap-timepicker-meridian"></span>'),f='<table><tr><td><a href="#" data-action="incrementHour"><span class="'+this.icons.up+'"></span></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><span class="'+this.icons.up+'"></span></a></td>'+(this.showSeconds?'<td class="separator">&nbsp;</td><td><a href="#" data-action="incrementSecond"><span class="'+this.icons.up+'"></span></a></td>':"")+(this.showMeridian?'<td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><span class="'+this.icons.up+'"></span></a></td>':"")+"</tr><tr><td>"+b+'</td> <td class="separator">:</td><td>'+c+"</td> "+(this.showSeconds?'<td class="separator">:</td><td>'+d+"</td>":"")+(this.showMeridian?'<td class="separator">&nbsp;</td><td>'+e+"</td>":"")+'</tr><tr><td><a href="#" data-action="decrementHour"><span class="'+this.icons.down+'"></span></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><span class="'+this.icons.down+'"></span></a></td>'+(this.showSeconds?'<td class="separator">&nbsp;</td><td><a href="#" data-action="decrementSecond"><span class="'+this.icons.down+'"></span></a></td>':"")+(this.showMeridian?'<td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><span class="'+this.icons.down+'"></span></a></td>':"")+"</tr></table>",this.template){case"modal":a='<div class="bootstrap-timepicker-widget modal hide fade in" data-backdrop="'+(this.modalBackdrop?"true":"false")+'"><div class="modal-header"><a href="#" class="close" data-dismiss="modal">&times;</a><h3>Pick a Time</h3></div><div class="modal-content">'+f+'</div><div class="modal-footer"><a href="#" class="btn btn-primary" data-dismiss="modal">OK</a></div></div>';break;case"dropdown":a='<div class="bootstrap-timepicker-widget dropdown-menu">'+f+"</div>"}return a},getTime:function(){return""===this.hour?"":this.hour+":"+(1===this.minute.toString().length?"0"+this.minute:this.minute)+(this.showSeconds?":"+(1===this.second.toString().length?"0"+this.second:this.second):"")+(this.showMeridian?" "+this.meridian:"")},hideWidget:function(){this.isOpen!==!1&&(this.$element.trigger({type:"hide.timepicker",time:{value:this.getTime(),hours:this.hour,minutes:this.minute,seconds:this.second,meridian:this.meridian}}),"modal"===this.template&&this.$widget.modal?this.$widget.modal("hide"):this.$widget.removeClass("open"),a(c).off("mousedown.timepicker, touchend.timepicker",this.handleDocumentClick),this.isOpen=!1,this.$widget.detach())},highlightUnit:function(){this.position=this.getCursorPosition(),this.position>=0&&this.position<=2?this.highlightHour():this.position>=3&&this.position<=5?this.highlightMinute():this.position>=6&&this.position<=8?this.showSeconds?this.highlightSecond():this.highlightMeridian():this.position>=9&&this.position<=11&&this.highlightMeridian()},highlightNextUnit:function(){switch(this.highlightedUnit){case"hour":this.highlightMinute();break;case"minute":this.showSeconds?this.highlightSecond():this.showMeridian?this.highlightMeridian():this.highlightHour();break;case"second":this.showMeridian?this.highlightMeridian():this.highlightHour();break;case"meridian":this.highlightHour()}},highlightPrevUnit:function(){switch(this.highlightedUnit){case"hour":this.showMeridian?this.highlightMeridian():this.showSeconds?this.highlightSecond():this.highlightMinute();break;case"minute":this.highlightHour();break;case"second":this.highlightMinute();break;case"meridian":this.showSeconds?this.highlightSecond():this.highlightMinute()}},highlightHour:function(){var a=this.$element.get(0),b=this;this.highlightedUnit="hour",a.setSelectionRange&&setTimeout(function(){b.hour<10?a.setSelectionRange(0,1):a.setSelectionRange(0,2)},0)},highlightMinute:function(){var a=this.$element.get(0),b=this;this.highlightedUnit="minute",a.setSelectionRange&&setTimeout(function(){b.hour<10?a.setSelectionRange(2,4):a.setSelectionRange(3,5)},0)},highlightSecond:function(){var a=this.$element.get(0),b=this;this.highlightedUnit="second",a.setSelectionRange&&setTimeout(function(){b.hour<10?a.setSelectionRange(5,7):a.setSelectionRange(6,8)},0)},highlightMeridian:function(){var a=this.$element.get(0),b=this;this.highlightedUnit="meridian",a.setSelectionRange&&(this.showSeconds?setTimeout(function(){b.hour<10?a.setSelectionRange(8,10):a.setSelectionRange(9,11)},0):setTimeout(function(){b.hour<10?a.setSelectionRange(5,7):a.setSelectionRange(6,8)},0))},incrementHour:function(){if(this.showMeridian){if(11===this.hour)return this.hour++,this.toggleMeridian();12===this.hour&&(this.hour=0)}return this.hour===this.maxHours-1?void(this.hour=0):void this.hour++},incrementMinute:function(a){var b;b=a?this.minute+a:this.minute+this.minuteStep-this.minute%this.minuteStep,b>59?(this.incrementHour(),this.minute=b-60):this.minute=b},incrementSecond:function(){var a=this.second+this.secondStep-this.second%this.secondStep;a>59?(this.incrementMinute(!0),this.second=a-60):this.second=a},mousewheel:function(b){if(!this.disableMousewheel){b.preventDefault(),b.stopPropagation();var c=b.originalEvent.wheelDelta||-b.originalEvent.detail,d=null;switch("mousewheel"===b.type?d=-1*b.originalEvent.wheelDelta:"DOMMouseScroll"===b.type&&(d=40*b.originalEvent.detail),d&&(b.preventDefault(),a(this).scrollTop(d+a(this).scrollTop())),this.highlightedUnit){case"minute":c>0?this.incrementMinute():this.decrementMinute(),this.highlightMinute();break;case"second":c>0?this.incrementSecond():this.decrementSecond(),this.highlightSecond();break;case"meridian":this.toggleMeridian(),this.highlightMeridian();break;default:c>0?this.incrementHour():this.decrementHour(),this.highlightHour()}return!1}},changeToNearestStep:function(a,b){return a%b===0?a:Math.round(a%b/b)?(a+(b-a%b))%60:a-a%b},place:function(){if(!this.isInline){var c=this.$widget.outerWidth(),d=this.$widget.outerHeight(),e=10,f=a(b).width(),g=a(b).height(),h=a(b).scrollTop(),i=parseInt(this.$element.parents().filter(function(){return"auto"!==a(this).css("z-index")}).first().css("z-index"),10)+10,j=this.component?this.component.parent().offset():this.$element.offset(),k=this.component?this.component.outerHeight(!0):this.$element.outerHeight(!1),l=this.component?this.component.outerWidth(!0):this.$element.outerWidth(!1),m=j.left,n=j.top;this.$widget.removeClass("timepicker-orient-top timepicker-orient-bottom timepicker-orient-right timepicker-orient-left"),"auto"!==this.orientation.x?(this.$widget.addClass("timepicker-orient-"+this.orientation.x),"right"===this.orientation.x&&(m-=c-l)):(this.$widget.addClass("timepicker-orient-left"),j.left<0?m-=j.left-e:j.left+c>f&&(m=f-c-e));var o,p,q=this.orientation.y;"auto"===q&&(o=-h+j.top-d,p=h+g-(j.top+k+d),q=Math.max(o,p)===p?"top":"bottom"),this.$widget.addClass("timepicker-orient-"+q),"top"===q?n+=k:n-=d+parseInt(this.$widget.css("padding-top"),10),this.$widget.css({top:n,left:m,zIndex:i})}},remove:function(){a("document").off(".timepicker"),this.$widget&&this.$widget.remove(),delete this.$element.data().timepicker},setDefaultTime:function(a){if(this.$element.val())this.updateFromElementVal();else if("current"===a){var b=new Date,c=b.getHours(),d=b.getMinutes(),e=b.getSeconds(),f="AM";0!==e&&(e=Math.ceil(b.getSeconds()/this.secondStep)*this.secondStep,60===e&&(d+=1,e=0)),0!==d&&(d=Math.ceil(b.getMinutes()/this.minuteStep)*this.minuteStep,60===d&&(c+=1,d=0)),this.showMeridian&&(0===c?c=12:c>=12?(c>12&&(c-=12),f="PM"):f="AM"),this.hour=c,this.minute=d,this.second=e,this.meridian=f,this.update()}else a===!1?(this.hour=0,this.minute=0,this.second=0,this.meridian="AM"):this.setTime(a)},setTime:function(a,b){if(!a)return void this.clear();var c,d,e,f,g,h;if("object"==typeof a&&a.getMonth)e=a.getHours(),f=a.getMinutes(),g=a.getSeconds(),this.showMeridian&&(h="AM",e>12&&(h="PM",e%=12),12===e&&(h="PM"));else{if(c=(/a/i.test(a)?1:0)+(/p/i.test(a)?2:0),c>2)return void this.clear();if(d=a.replace(/[^0-9\:]/g,"").split(":"),e=d[0]?d[0].toString():d.toString(),this.explicitMode&&e.length>2&&e.length%2!==0)return void this.clear();f=d[1]?d[1].toString():"",g=d[2]?d[2].toString():"",e.length>4&&(g=e.slice(-2),e=e.slice(0,-2)),e.length>2&&(f=e.slice(-2),e=e.slice(0,-2)),f.length>2&&(g=f.slice(-2),f=f.slice(0,-2)),e=parseInt(e,10),f=parseInt(f,10),g=parseInt(g,10),isNaN(e)&&(e=0),isNaN(f)&&(f=0),isNaN(g)&&(g=0),g>59&&(g=59),f>59&&(f=59),e>=this.maxHours&&(e=this.maxHours-1),this.showMeridian?(e>12&&(c=2,e-=12),c||(c=1),0===e&&(e=12),h=1===c?"AM":"PM"):12>e&&2===c?e+=12:e>=this.maxHours?e=this.maxHours-1:(0>e||12===e&&1===c)&&(e=0)}this.hour=e,this.snapToStep?(this.minute=this.changeToNearestStep(f,this.minuteStep),this.second=this.changeToNearestStep(g,this.secondStep)):(this.minute=f,this.second=g),this.meridian=h,this.update(b)},showWidget:function(){this.isOpen||this.$element.is(":disabled")||(this.$widget.appendTo(this.appendWidgetTo),a(c).on("mousedown.timepicker, touchend.timepicker",{scope:this},this.handleDocumentClick),this.$element.trigger({type:"show.timepicker",time:{value:this.getTime(),hours:this.hour,minutes:this.minute,seconds:this.second,meridian:this.meridian}}),this.place(),this.disableFocus&&this.$element.blur(),""===this.hour&&(this.defaultTime?this.setDefaultTime(this.defaultTime):this.setTime("0:0:0")),"modal"===this.template&&this.$widget.modal?this.$widget.modal("show").on("hidden",a.proxy(this.hideWidget,this)):this.isOpen===!1&&this.$widget.addClass("open"),this.isOpen=!0)},toggleMeridian:function(){this.meridian="AM"===this.meridian?"PM":"AM"},update:function(a){this.updateElement(),a||this.updateWidget(),this.$element.trigger({type:"changeTime.timepicker",time:{value:this.getTime(),hours:this.hour,minutes:this.minute,seconds:this.second,meridian:this.meridian}})},updateElement:function(){this.$element.val(this.getTime()).change()},updateFromElementVal:function(){this.setTime(this.$element.val())},updateWidget:function(){if(this.$widget!==!1){var a=this.hour,b=1===this.minute.toString().length?"0"+this.minute:this.minute,c=1===this.second.toString().length?"0"+this.second:this.second;this.showInputs?(this.$widget.find("input.bootstrap-timepicker-hour").val(a),this.$widget.find("input.bootstrap-timepicker-minute").val(b),this.showSeconds&&this.$widget.find("input.bootstrap-timepicker-second").val(c),this.showMeridian&&this.$widget.find("input.bootstrap-timepicker-meridian").val(this.meridian)):(this.$widget.find("span.bootstrap-timepicker-hour").text(a),this.$widget.find("span.bootstrap-timepicker-minute").text(b),this.showSeconds&&this.$widget.find("span.bootstrap-timepicker-second").text(c),this.showMeridian&&this.$widget.find("span.bootstrap-timepicker-meridian").text(this.meridian))}},updateFromWidgetInputs:function(){if(this.$widget!==!1){var a=this.$widget.find("input.bootstrap-timepicker-hour").val()+":"+this.$widget.find("input.bootstrap-timepicker-minute").val()+(this.showSeconds?":"+this.$widget.find("input.bootstrap-timepicker-second").val():"")+(this.showMeridian?this.$widget.find("input.bootstrap-timepicker-meridian").val():"");this.setTime(a,!0)}},widgetClick:function(b){b.stopPropagation(),b.preventDefault();var c=a(b.target),d=c.closest("a").data("action");d&&this[d](),this.update(),c.is("input")&&c.get(0).setSelectionRange(0,2)},widgetKeydown:function(b){var c=a(b.target),d=c.attr("class").replace("bootstrap-timepicker-","");switch(b.which){case 9:if(b.shiftKey){if("hour"===d)return this.hideWidget()}else if(this.showMeridian&&"meridian"===d||this.showSeconds&&"second"===d||!this.showMeridian&&!this.showSeconds&&"minute"===d)return this.hideWidget();break;case 27:this.hideWidget();break;case 38:switch(b.preventDefault(),d){case"hour":this.incrementHour();break;case"minute":this.incrementMinute();break;case"second":this.incrementSecond();break;case"meridian":this.toggleMeridian()}this.setTime(this.getTime()),c.get(0).setSelectionRange(0,2);break;case 40:switch(b.preventDefault(),d){case"hour":this.decrementHour();break;case"minute":this.decrementMinute();break;case"second":this.decrementSecond();break;case"meridian":this.toggleMeridian()}this.setTime(this.getTime()),c.get(0).setSelectionRange(0,2)}},widgetKeyup:function(a){(65===a.which||77===a.which||80===a.which||46===a.which||8===a.which||a.which>=48&&a.which<=57||a.which>=96&&a.which<=105)&&this.updateFromWidgetInputs()}},a.fn.timepicker=function(b){var c=Array.apply(null,arguments);return c.shift(),this.each(function(){var e=a(this),f=e.data("timepicker"),g="object"==typeof b&&b;f||e.data("timepicker",f=new d(this,a.extend({},a.fn.timepicker.defaults,g,a(this).data()))),"string"==typeof b&&f[b].apply(f,c)})},a.fn.timepicker.defaults={defaultTime:"current",disableFocus:!1,disableMousewheel:!1,isOpen:!1,minuteStep:15,modalBackdrop:!1,orientation:{x:"auto",y:"auto"},secondStep:15,snapToStep:!1,showSeconds:!1,showInputs:!0,showMeridian:!0,template:"dropdown",appendWidgetTo:"body",showWidgetOnAddonClick:!0,icons:{up:"glyphicon glyphicon-chevron-up",down:"glyphicon glyphicon-chevron-down"},maxHours:24,explicitMode:!1},a.fn.timepicker.Constructor=d,a(c).on("focus.timepicker.data-api click.timepicker.data-api",'[data-provide="timepicker"]',function(b){var c=a(this);c.data("timepicker")||(b.preventDefault(),c.timepicker())})}(jQuery,window,document);
"use strict";
$.fn.timepicker.defaults = $.extend(true, {}, $.fn.timepicker.defaults, {
    icons: {
        up: 'ki ki-arrow-up',
        down: 'ki ki-arrow-down'
    }
});

/**
* @version: 3.1
* @author: Dan Grossman http://www.dangrossman.info/
* @copyright: Copyright (c) 2012-2019 Dan Grossman. All rights reserved.
* @license: Licensed under the MIT license. See http://www.opensource.org/licenses/mit-license.php
* @website: http://www.daterangepicker.com/
*/
// Following the UMD template https://github.com/umdjs/umd/blob/master/templates/returnExportsGlobal.js
(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Make globaly available as well
        define(['moment', 'jquery'], function (moment, jquery) {
            if (!jquery.fn) jquery.fn = {}; // webpack server rendering
            if (typeof moment !== 'function' && moment.hasOwnProperty('default')) moment = moment['default']
            return factory(moment, jquery);
        });
    } else if (typeof module === 'object' && module.exports) {
        // Node / Browserify
        //isomorphic issue
        var jQuery = (typeof window != 'undefined') ? window.jQuery : undefined;
        if (!jQuery) {
            jQuery = require('jquery');
            if (!jQuery.fn) jQuery.fn = {};
        }
        var moment = (typeof window != 'undefined' && typeof window.moment != 'undefined') ? window.moment : require('moment');
        module.exports = factory(moment, jQuery);
    } else {
        // Browser globals
        root.daterangepicker = factory(root.moment, root.jQuery);
    }
}(this, function(moment, $) {
    var DateRangePicker = function(element, options, cb) {

        //default settings for options
        this.parentEl = 'body';
        this.element = $(element);
        this.startDate = moment().startOf('day');
        this.endDate = moment().endOf('day');
        this.minDate = false;
        this.maxDate = false;
        this.maxSpan = false;
        this.autoApply = false;
        this.singleDatePicker = false;
        this.showDropdowns = false;
        this.minYear = moment().subtract(100, 'year').format('YYYY');
        this.maxYear = moment().add(100, 'year').format('YYYY');
        this.showWeekNumbers = false;
        this.showISOWeekNumbers = false;
        this.showCustomRangeLabel = true;
        this.timePicker = false;
        this.timePicker24Hour = false;
        this.timePickerIncrement = 1;
        this.timePickerSeconds = false;
        this.linkedCalendars = true;
        this.autoUpdateInput = true;
        this.alwaysShowCalendars = false;
        this.ranges = {};

        this.opens = 'right';
        if (this.element.hasClass('pull-right'))
            this.opens = 'left';

        this.drops = 'down';
        if (this.element.hasClass('dropup'))
            this.drops = 'up';

        this.buttonClasses = 'btn btn-sm';
        this.applyButtonClasses = 'btn-primary';
        this.cancelButtonClasses = 'btn-default';

        this.locale = {
            direction: 'ltr',
            format: moment.localeData().longDateFormat('L'),
            separator: ' - ',
            applyLabel: 'Apply',
            cancelLabel: 'Cancel',
            weekLabel: 'W',
            customRangeLabel: 'Custom Range',
            daysOfWeek: moment.weekdaysMin(),
            monthNames: moment.monthsShort(),
            firstDay: moment.localeData().firstDayOfWeek()
        };

        this.callback = function() { };

        //some state information
        this.isShowing = false;
        this.leftCalendar = {};
        this.rightCalendar = {};

        //custom options from user
        if (typeof options !== 'object' || options === null)
            options = {};

        //allow setting options with data attributes
        //data-api options will be overwritten with custom javascript options
        options = $.extend(this.element.data(), options);

        //html template for the picker UI
        if (typeof options.template !== 'string' && !(options.template instanceof $))
            options.template =
            '<div class="daterangepicker">' +
                '<div class="ranges"></div>' +
                '<div class="drp-calendar left">' +
                    '<div class="calendar-table"></div>' +
                    '<div class="calendar-time"></div>' +
                '</div>' +
                '<div class="drp-calendar right">' +
                    '<div class="calendar-table"></div>' +
                    '<div class="calendar-time"></div>' +
                '</div>' +
                '<div class="drp-buttons">' +
                    '<span class="drp-selected"></span>' +
                    '<button class="cancelBtn" type="button"></button>' +
                    '<button class="applyBtn" disabled="disabled" type="button"></button> ' +
                '</div>' +
            '</div>';

        this.parentEl = (options.parentEl && $(options.parentEl).length) ? $(options.parentEl) : $(this.parentEl);
        this.container = $(options.template).appendTo(this.parentEl);

        //
        // handle all the possible options overriding defaults
        //

        if (typeof options.locale === 'object') {

            if (typeof options.locale.direction === 'string')
                this.locale.direction = options.locale.direction;

            if (typeof options.locale.format === 'string')
                this.locale.format = options.locale.format;

            if (typeof options.locale.separator === 'string')
                this.locale.separator = options.locale.separator;

            if (typeof options.locale.daysOfWeek === 'object')
                this.locale.daysOfWeek = options.locale.daysOfWeek.slice();

            if (typeof options.locale.monthNames === 'object')
              this.locale.monthNames = options.locale.monthNames.slice();

            if (typeof options.locale.firstDay === 'number')
              this.locale.firstDay = options.locale.firstDay;

            if (typeof options.locale.applyLabel === 'string')
              this.locale.applyLabel = options.locale.applyLabel;

            if (typeof options.locale.cancelLabel === 'string')
              this.locale.cancelLabel = options.locale.cancelLabel;

            if (typeof options.locale.weekLabel === 'string')
              this.locale.weekLabel = options.locale.weekLabel;

            if (typeof options.locale.customRangeLabel === 'string'){
                //Support unicode chars in the custom range name.
                var elem = document.createElement('textarea');
                elem.innerHTML = options.locale.customRangeLabel;
                var rangeHtml = elem.value;
                this.locale.customRangeLabel = rangeHtml;
            }
        }
        this.container.addClass(this.locale.direction);

        if (typeof options.startDate === 'string')
            this.startDate = moment(options.startDate, this.locale.format);

        if (typeof options.endDate === 'string')
            this.endDate = moment(options.endDate, this.locale.format);

        if (typeof options.minDate === 'string')
            this.minDate = moment(options.minDate, this.locale.format);

        if (typeof options.maxDate === 'string')
            this.maxDate = moment(options.maxDate, this.locale.format);

        if (typeof options.startDate === 'object')
            this.startDate = moment(options.startDate);

        if (typeof options.endDate === 'object')
            this.endDate = moment(options.endDate);

        if (typeof options.minDate === 'object')
            this.minDate = moment(options.minDate);

        if (typeof options.maxDate === 'object')
            this.maxDate = moment(options.maxDate);

        // sanity check for bad options
        if (this.minDate && this.startDate.isBefore(this.minDate))
            this.startDate = this.minDate.clone();

        // sanity check for bad options
        if (this.maxDate && this.endDate.isAfter(this.maxDate))
            this.endDate = this.maxDate.clone();

        if (typeof options.applyButtonClasses === 'string')
            this.applyButtonClasses = options.applyButtonClasses;

        if (typeof options.applyClass === 'string') //backwards compat
            this.applyButtonClasses = options.applyClass;

        if (typeof options.cancelButtonClasses === 'string')
            this.cancelButtonClasses = options.cancelButtonClasses;

        if (typeof options.cancelClass === 'string') //backwards compat
            this.cancelButtonClasses = options.cancelClass;

        if (typeof options.maxSpan === 'object')
            this.maxSpan = options.maxSpan;

        if (typeof options.dateLimit === 'object') //backwards compat
            this.maxSpan = options.dateLimit;

        if (typeof options.opens === 'string')
            this.opens = options.opens;

        if (typeof options.drops === 'string')
            this.drops = options.drops;

        if (typeof options.showWeekNumbers === 'boolean')
            this.showWeekNumbers = options.showWeekNumbers;

        if (typeof options.showISOWeekNumbers === 'boolean')
            this.showISOWeekNumbers = options.showISOWeekNumbers;

        if (typeof options.buttonClasses === 'string')
            this.buttonClasses = options.buttonClasses;

        if (typeof options.buttonClasses === 'object')
            this.buttonClasses = options.buttonClasses.join(' ');

        if (typeof options.showDropdowns === 'boolean')
            this.showDropdowns = options.showDropdowns;

        if (typeof options.minYear === 'number')
            this.minYear = options.minYear;

        if (typeof options.maxYear === 'number')
            this.maxYear = options.maxYear;

        if (typeof options.showCustomRangeLabel === 'boolean')
            this.showCustomRangeLabel = options.showCustomRangeLabel;

        if (typeof options.singleDatePicker === 'boolean') {
            this.singleDatePicker = options.singleDatePicker;
            if (this.singleDatePicker)
                this.endDate = this.startDate.clone();
        }

        if (typeof options.timePicker === 'boolean')
            this.timePicker = options.timePicker;

        if (typeof options.timePickerSeconds === 'boolean')
            this.timePickerSeconds = options.timePickerSeconds;

        if (typeof options.timePickerIncrement === 'number')
            this.timePickerIncrement = options.timePickerIncrement;

        if (typeof options.timePicker24Hour === 'boolean')
            this.timePicker24Hour = options.timePicker24Hour;

        if (typeof options.autoApply === 'boolean')
            this.autoApply = options.autoApply;

        if (typeof options.autoUpdateInput === 'boolean')
            this.autoUpdateInput = options.autoUpdateInput;

        if (typeof options.linkedCalendars === 'boolean')
            this.linkedCalendars = options.linkedCalendars;

        if (typeof options.isInvalidDate === 'function')
            this.isInvalidDate = options.isInvalidDate;

        if (typeof options.isCustomDate === 'function')
            this.isCustomDate = options.isCustomDate;

        if (typeof options.alwaysShowCalendars === 'boolean')
            this.alwaysShowCalendars = options.alwaysShowCalendars;

        // update day names order to firstDay
        if (this.locale.firstDay != 0) {
            var iterator = this.locale.firstDay;
            while (iterator > 0) {
                this.locale.daysOfWeek.push(this.locale.daysOfWeek.shift());
                iterator--;
            }
        }

        var start, end, range;

        //if no start/end dates set, check if an input element contains initial values
        if (typeof options.startDate === 'undefined' && typeof options.endDate === 'undefined') {
            if ($(this.element).is(':text')) {
                var val = $(this.element).val(),
                    split = val.split(this.locale.separator);

                start = end = null;

                if (split.length == 2) {
                    start = moment(split[0], this.locale.format);
                    end = moment(split[1], this.locale.format);
                } else if (this.singleDatePicker && val !== "") {
                    start = moment(val, this.locale.format);
                    end = moment(val, this.locale.format);
                }
                if (start !== null && end !== null) {
                    this.setStartDate(start);
                    this.setEndDate(end);
                }
            }
        }

        if (typeof options.ranges === 'object') {
            for (range in options.ranges) {

                if (typeof options.ranges[range][0] === 'string')
                    start = moment(options.ranges[range][0], this.locale.format);
                else
                    start = moment(options.ranges[range][0]);

                if (typeof options.ranges[range][1] === 'string')
                    end = moment(options.ranges[range][1], this.locale.format);
                else
                    end = moment(options.ranges[range][1]);

                // If the start or end date exceed those allowed by the minDate or maxSpan
                // options, shorten the range to the allowable period.
                if (this.minDate && start.isBefore(this.minDate))
                    start = this.minDate.clone();

                var maxDate = this.maxDate;
                if (this.maxSpan && maxDate && start.clone().add(this.maxSpan).isAfter(maxDate))
                    maxDate = start.clone().add(this.maxSpan);
                if (maxDate && end.isAfter(maxDate))
                    end = maxDate.clone();

                // If the end of the range is before the minimum or the start of the range is
                // after the maximum, don't display this range option at all.
                if ((this.minDate && end.isBefore(this.minDate, this.timepicker ? 'minute' : 'day'))
                  || (maxDate && start.isAfter(maxDate, this.timepicker ? 'minute' : 'day')))
                    continue;

                //Support unicode chars in the range names.
                var elem = document.createElement('textarea');
                elem.innerHTML = range;
                var rangeHtml = elem.value;

                this.ranges[rangeHtml] = [start, end];
            }

            var list = '<ul>';
            for (range in this.ranges) {
                list += '<li data-range-key="' + range + '">' + range + '</li>';
            }
            if (this.showCustomRangeLabel) {
                list += '<li data-range-key="' + this.locale.customRangeLabel + '">' + this.locale.customRangeLabel + '</li>';
            }
            list += '</ul>';
            this.container.find('.ranges').prepend(list);
        }

        if (typeof cb === 'function') {
            this.callback = cb;
        }

        if (!this.timePicker) {
            this.startDate = this.startDate.startOf('day');
            this.endDate = this.endDate.endOf('day');
            this.container.find('.calendar-time').hide();
        }

        //can't be used together for now
        if (this.timePicker && this.autoApply)
            this.autoApply = false;

        if (this.autoApply) {
            this.container.addClass('auto-apply');
        }

        if (typeof options.ranges === 'object')
            this.container.addClass('show-ranges');

        if (this.singleDatePicker) {
            this.container.addClass('single');
            this.container.find('.drp-calendar.left').addClass('single');
            this.container.find('.drp-calendar.left').show();
            this.container.find('.drp-calendar.right').hide();
            if (!this.timePicker && this.autoApply) {
                this.container.addClass('auto-apply');
            }
        }

        if ((typeof options.ranges === 'undefined' && !this.singleDatePicker) || this.alwaysShowCalendars) {
            this.container.addClass('show-calendar');
        }

        this.container.addClass('opens' + this.opens);

        //apply CSS classes and labels to buttons
        this.container.find('.applyBtn, .cancelBtn').addClass(this.buttonClasses);
        if (this.applyButtonClasses.length)
            this.container.find('.applyBtn').addClass(this.applyButtonClasses);
        if (this.cancelButtonClasses.length)
            this.container.find('.cancelBtn').addClass(this.cancelButtonClasses);
        this.container.find('.applyBtn').html(this.locale.applyLabel);
        this.container.find('.cancelBtn').html(this.locale.cancelLabel);

        //
        // event listeners
        //

        this.container.find('.drp-calendar')
            .on('click.daterangepicker', '.prev', $.proxy(this.clickPrev, this))
            .on('click.daterangepicker', '.next', $.proxy(this.clickNext, this))
            .on('mousedown.daterangepicker', 'td.available', $.proxy(this.clickDate, this))
            .on('mouseenter.daterangepicker', 'td.available', $.proxy(this.hoverDate, this))
            .on('change.daterangepicker', 'select.yearselect', $.proxy(this.monthOrYearChanged, this))
            .on('change.daterangepicker', 'select.monthselect', $.proxy(this.monthOrYearChanged, this))
            .on('change.daterangepicker', 'select.hourselect,select.minuteselect,select.secondselect,select.ampmselect', $.proxy(this.timeChanged, this));

        this.container.find('.ranges')
            .on('click.daterangepicker', 'li', $.proxy(this.clickRange, this));

        this.container.find('.drp-buttons')
            .on('click.daterangepicker', 'button.applyBtn', $.proxy(this.clickApply, this))
            .on('click.daterangepicker', 'button.cancelBtn', $.proxy(this.clickCancel, this));

        if (this.element.is('input') || this.element.is('button')) {
            this.element.on({
                'click.daterangepicker': $.proxy(this.show, this),
                'focus.daterangepicker': $.proxy(this.show, this),
                'keyup.daterangepicker': $.proxy(this.elementChanged, this),
                'keydown.daterangepicker': $.proxy(this.keydown, this) //IE 11 compatibility
            });
        } else {
            this.element.on('click.daterangepicker', $.proxy(this.toggle, this));
            this.element.on('keydown.daterangepicker', $.proxy(this.toggle, this));
        }

        //
        // if attached to a text input, set the initial value
        //

        this.updateElement();

    };

    DateRangePicker.prototype = {

        constructor: DateRangePicker,

        setStartDate: function(startDate) {
            if (typeof startDate === 'string')
                this.startDate = moment(startDate, this.locale.format);

            if (typeof startDate === 'object')
                this.startDate = moment(startDate);

            if (!this.timePicker)
                this.startDate = this.startDate.startOf('day');

            if (this.timePicker && this.timePickerIncrement)
                this.startDate.minute(Math.round(this.startDate.minute() / this.timePickerIncrement) * this.timePickerIncrement);

            if (this.minDate && this.startDate.isBefore(this.minDate)) {
                this.startDate = this.minDate.clone();
                if (this.timePicker && this.timePickerIncrement)
                    this.startDate.minute(Math.round(this.startDate.minute() / this.timePickerIncrement) * this.timePickerIncrement);
            }

            if (this.maxDate && this.startDate.isAfter(this.maxDate)) {
                this.startDate = this.maxDate.clone();
                if (this.timePicker && this.timePickerIncrement)
                    this.startDate.minute(Math.floor(this.startDate.minute() / this.timePickerIncrement) * this.timePickerIncrement);
            }

            if (!this.isShowing)
                this.updateElement();

            this.updateMonthsInView();
        },

        setEndDate: function(endDate) {
            if (typeof endDate === 'string')
                this.endDate = moment(endDate, this.locale.format);

            if (typeof endDate === 'object')
                this.endDate = moment(endDate);

            if (!this.timePicker)
                this.endDate = this.endDate.endOf('day');

            if (this.timePicker && this.timePickerIncrement)
                this.endDate.minute(Math.round(this.endDate.minute() / this.timePickerIncrement) * this.timePickerIncrement);

            if (this.endDate.isBefore(this.startDate))
                this.endDate = this.startDate.clone();

            if (this.maxDate && this.endDate.isAfter(this.maxDate))
                this.endDate = this.maxDate.clone();

            if (this.maxSpan && this.startDate.clone().add(this.maxSpan).isBefore(this.endDate))
                this.endDate = this.startDate.clone().add(this.maxSpan);

            this.previousRightTime = this.endDate.clone();

            this.container.find('.drp-selected').html(this.startDate.format(this.locale.format) + this.locale.separator + this.endDate.format(this.locale.format));

            if (!this.isShowing)
                this.updateElement();

            this.updateMonthsInView();
        },

        isInvalidDate: function() {
            return false;
        },

        isCustomDate: function() {
            return false;
        },

        updateView: function() {
            if (this.timePicker) {
                this.renderTimePicker('left');
                this.renderTimePicker('right');
                if (!this.endDate) {
                    this.container.find('.right .calendar-time select').prop('disabled', true).addClass('disabled');
                } else {
                    this.container.find('.right .calendar-time select').prop('disabled', false).removeClass('disabled');
                }
            }
            if (this.endDate)
                this.container.find('.drp-selected').html(this.startDate.format(this.locale.format) + this.locale.separator + this.endDate.format(this.locale.format));
            this.updateMonthsInView();
            this.updateCalendars();
            this.updateFormInputs();
        },

        updateMonthsInView: function() {
            if (this.endDate) {

                //if both dates are visible already, do nothing
                if (!this.singleDatePicker && this.leftCalendar.month && this.rightCalendar.month &&
                    (this.startDate.format('YYYY-MM') == this.leftCalendar.month.format('YYYY-MM') || this.startDate.format('YYYY-MM') == this.rightCalendar.month.format('YYYY-MM'))
                    &&
                    (this.endDate.format('YYYY-MM') == this.leftCalendar.month.format('YYYY-MM') || this.endDate.format('YYYY-MM') == this.rightCalendar.month.format('YYYY-MM'))
                    ) {
                    return;
                }

                this.leftCalendar.month = this.startDate.clone().date(2);
                if (!this.linkedCalendars && (this.endDate.month() != this.startDate.month() || this.endDate.year() != this.startDate.year())) {
                    this.rightCalendar.month = this.endDate.clone().date(2);
                } else {
                    this.rightCalendar.month = this.startDate.clone().date(2).add(1, 'month');
                }

            } else {
                if (this.leftCalendar.month.format('YYYY-MM') != this.startDate.format('YYYY-MM') && this.rightCalendar.month.format('YYYY-MM') != this.startDate.format('YYYY-MM')) {
                    this.leftCalendar.month = this.startDate.clone().date(2);
                    this.rightCalendar.month = this.startDate.clone().date(2).add(1, 'month');
                }
            }
            if (this.maxDate && this.linkedCalendars && !this.singleDatePicker && this.rightCalendar.month > this.maxDate) {
              this.rightCalendar.month = this.maxDate.clone().date(2);
              this.leftCalendar.month = this.maxDate.clone().date(2).subtract(1, 'month');
            }
        },

        updateCalendars: function() {

            if (this.timePicker) {
                var hour, minute, second;
                if (this.endDate) {
                    hour = parseInt(this.container.find('.left .hourselect').val(), 10);
                    minute = parseInt(this.container.find('.left .minuteselect').val(), 10);
                    if (isNaN(minute)) {
                        minute = parseInt(this.container.find('.left .minuteselect option:last').val(), 10);
                    }
                    second = this.timePickerSeconds ? parseInt(this.container.find('.left .secondselect').val(), 10) : 0;
                    if (!this.timePicker24Hour) {
                        var ampm = this.container.find('.left .ampmselect').val();
                        if (ampm === 'PM' && hour < 12)
                            hour += 12;
                        if (ampm === 'AM' && hour === 12)
                            hour = 0;
                    }
                } else {
                    hour = parseInt(this.container.find('.right .hourselect').val(), 10);
                    minute = parseInt(this.container.find('.right .minuteselect').val(), 10);
                    if (isNaN(minute)) {
                        minute = parseInt(this.container.find('.right .minuteselect option:last').val(), 10);
                    }
                    second = this.timePickerSeconds ? parseInt(this.container.find('.right .secondselect').val(), 10) : 0;
                    if (!this.timePicker24Hour) {
                        var ampm = this.container.find('.right .ampmselect').val();
                        if (ampm === 'PM' && hour < 12)
                            hour += 12;
                        if (ampm === 'AM' && hour === 12)
                            hour = 0;
                    }
                }
                this.leftCalendar.month.hour(hour).minute(minute).second(second);
                this.rightCalendar.month.hour(hour).minute(minute).second(second);
            }

            this.renderCalendar('left');
            this.renderCalendar('right');

            //highlight any predefined range matching the current start and end dates
            this.container.find('.ranges li').removeClass('active');
            if (this.endDate == null) return;

            this.calculateChosenLabel();
        },

        renderCalendar: function(side) {

            //
            // Build the matrix of dates that will populate the calendar
            //

            var calendar = side == 'left' ? this.leftCalendar : this.rightCalendar;
            var month = calendar.month.month();
            var year = calendar.month.year();
            var hour = calendar.month.hour();
            var minute = calendar.month.minute();
            var second = calendar.month.second();
            var daysInMonth = moment([year, month]).daysInMonth();
            var firstDay = moment([year, month, 1]);
            var lastDay = moment([year, month, daysInMonth]);
            var lastMonth = moment(firstDay).subtract(1, 'month').month();
            var lastYear = moment(firstDay).subtract(1, 'month').year();
            var daysInLastMonth = moment([lastYear, lastMonth]).daysInMonth();
            var dayOfWeek = firstDay.day();

            //initialize a 6 rows x 7 columns array for the calendar
            var calendar = [];
            calendar.firstDay = firstDay;
            calendar.lastDay = lastDay;

            for (var i = 0; i < 6; i++) {
                calendar[i] = [];
            }

            //populate the calendar with date objects
            var startDay = daysInLastMonth - dayOfWeek + this.locale.firstDay + 1;
            if (startDay > daysInLastMonth)
                startDay -= 7;

            if (dayOfWeek == this.locale.firstDay)
                startDay = daysInLastMonth - 6;

            var curDate = moment([lastYear, lastMonth, startDay, 12, minute, second]);

            var col, row;
            for (var i = 0, col = 0, row = 0; i < 42; i++, col++, curDate = moment(curDate).add(24, 'hour')) {
                if (i > 0 && col % 7 === 0) {
                    col = 0;
                    row++;
                }
                calendar[row][col] = curDate.clone().hour(hour).minute(minute).second(second);
                curDate.hour(12);

                if (this.minDate && calendar[row][col].format('YYYY-MM-DD') == this.minDate.format('YYYY-MM-DD') && calendar[row][col].isBefore(this.minDate) && side == 'left') {
                    calendar[row][col] = this.minDate.clone();
                }

                if (this.maxDate && calendar[row][col].format('YYYY-MM-DD') == this.maxDate.format('YYYY-MM-DD') && calendar[row][col].isAfter(this.maxDate) && side == 'right') {
                    calendar[row][col] = this.maxDate.clone();
                }

            }

            //make the calendar object available to hoverDate/clickDate
            if (side == 'left') {
                this.leftCalendar.calendar = calendar;
            } else {
                this.rightCalendar.calendar = calendar;
            }

            //
            // Display the calendar
            //

            var minDate = side == 'left' ? this.minDate : this.startDate;
            var maxDate = this.maxDate;
            var selected = side == 'left' ? this.startDate : this.endDate;
            var arrow = this.locale.direction == 'ltr' ? {left: 'chevron-left', right: 'chevron-right'} : {left: 'chevron-right', right: 'chevron-left'};

            var html = '<table class="table-condensed">';
            html += '<thead>';
            html += '<tr>';

            // add empty cell for week number
            if (this.showWeekNumbers || this.showISOWeekNumbers)
                html += '<th></th>';

            if ((!minDate || minDate.isBefore(calendar.firstDay)) && (!this.linkedCalendars || side == 'left')) {
                html += '<th class="prev available"><span></span></th>';
            } else {
                html += '<th></th>';
            }

            var dateHtml = this.locale.monthNames[calendar[1][1].month()] + calendar[1][1].format(" YYYY");

            if (this.showDropdowns) {
                var currentMonth = calendar[1][1].month();
                var currentYear = calendar[1][1].year();
                var maxYear = (maxDate && maxDate.year()) || (this.maxYear);
                var minYear = (minDate && minDate.year()) || (this.minYear);
                var inMinYear = currentYear == minYear;
                var inMaxYear = currentYear == maxYear;

                var monthHtml = '<select class="monthselect">';
                for (var m = 0; m < 12; m++) {
                    if ((!inMinYear || (minDate && m >= minDate.month())) && (!inMaxYear || (maxDate && m <= maxDate.month()))) {
                        monthHtml += "<option value='" + m + "'" +
                            (m === currentMonth ? " selected='selected'" : "") +
                            ">" + this.locale.monthNames[m] + "</option>";
                    } else {
                        monthHtml += "<option value='" + m + "'" +
                            (m === currentMonth ? " selected='selected'" : "") +
                            " disabled='disabled'>" + this.locale.monthNames[m] + "</option>";
                    }
                }
                monthHtml += "</select>";

                var yearHtml = '<select class="yearselect">';
                for (var y = minYear; y <= maxYear; y++) {
                    yearHtml += '<option value="' + y + '"' +
                        (y === currentYear ? ' selected="selected"' : '') +
                        '>' + y + '</option>';
                }
                yearHtml += '</select>';

                dateHtml = monthHtml + yearHtml;
            }

            html += '<th colspan="5" class="month">' + dateHtml + '</th>';
            if ((!maxDate || maxDate.isAfter(calendar.lastDay)) && (!this.linkedCalendars || side == 'right' || this.singleDatePicker)) {
                html += '<th class="next available"><span></span></th>';
            } else {
                html += '<th></th>';
            }

            html += '</tr>';
            html += '<tr>';

            // add week number label
            if (this.showWeekNumbers || this.showISOWeekNumbers)
                html += '<th class="week">' + this.locale.weekLabel + '</th>';

            $.each(this.locale.daysOfWeek, function(index, dayOfWeek) {
                html += '<th>' + dayOfWeek + '</th>';
            });

            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //adjust maxDate to reflect the maxSpan setting in order to
            //grey out end dates beyond the maxSpan
            if (this.endDate == null && this.maxSpan) {
                var maxLimit = this.startDate.clone().add(this.maxSpan).endOf('day');
                if (!maxDate || maxLimit.isBefore(maxDate)) {
                    maxDate = maxLimit;
                }
            }

            for (var row = 0; row < 6; row++) {
                html += '<tr>';

                // add week number
                if (this.showWeekNumbers)
                    html += '<td class="week">' + calendar[row][0].week() + '</td>';
                else if (this.showISOWeekNumbers)
                    html += '<td class="week">' + calendar[row][0].isoWeek() + '</td>';

                for (var col = 0; col < 7; col++) {

                    var classes = [];

                    //highlight today's date
                    if (calendar[row][col].isSame(new Date(), "day"))
                        classes.push('today');

                    //highlight weekends
                    if (calendar[row][col].isoWeekday() > 5)
                        classes.push('weekend');

                    //grey out the dates in other months displayed at beginning and end of this calendar
                    if (calendar[row][col].month() != calendar[1][1].month())
                        classes.push('off', 'ends');

                    //don't allow selection of dates before the minimum date
                    if (this.minDate && calendar[row][col].isBefore(this.minDate, 'day'))
                        classes.push('off', 'disabled');

                    //don't allow selection of dates after the maximum date
                    if (maxDate && calendar[row][col].isAfter(maxDate, 'day'))
                        classes.push('off', 'disabled');

                    //don't allow selection of date if a custom function decides it's invalid
                    if (this.isInvalidDate(calendar[row][col]))
                        classes.push('off', 'disabled');

                    //highlight the currently selected start date
                    if (calendar[row][col].format('YYYY-MM-DD') == this.startDate.format('YYYY-MM-DD'))
                        classes.push('active', 'start-date');

                    //highlight the currently selected end date
                    if (this.endDate != null && calendar[row][col].format('YYYY-MM-DD') == this.endDate.format('YYYY-MM-DD'))
                        classes.push('active', 'end-date');

                    //highlight dates in-between the selected dates
                    if (this.endDate != null && calendar[row][col] > this.startDate && calendar[row][col] < this.endDate)
                        classes.push('in-range');

                    //apply custom classes for this date
                    var isCustom = this.isCustomDate(calendar[row][col]);
                    if (isCustom !== false) {
                        if (typeof isCustom === 'string')
                            classes.push(isCustom);
                        else
                            Array.prototype.push.apply(classes, isCustom);
                    }

                    var cname = '', disabled = false;
                    for (var i = 0; i < classes.length; i++) {
                        cname += classes[i] + ' ';
                        if (classes[i] == 'disabled')
                            disabled = true;
                    }
                    if (!disabled)
                        cname += 'available';

                    html += '<td class="' + cname.replace(/^\s+|\s+$/g, '') + '" data-title="' + 'r' + row + 'c' + col + '">' + calendar[row][col].date() + '</td>';

                }
                html += '</tr>';
            }

            html += '</tbody>';
            html += '</table>';

            this.container.find('.drp-calendar.' + side + ' .calendar-table').html(html);

        },

        renderTimePicker: function(side) {

            // Don't bother updating the time picker if it's currently disabled
            // because an end date hasn't been clicked yet
            if (side == 'right' && !this.endDate) return;

            var html, selected, minDate, maxDate = this.maxDate;

            if (this.maxSpan && (!this.maxDate || this.startDate.clone().add(this.maxSpan).isBefore(this.maxDate)))
                maxDate = this.startDate.clone().add(this.maxSpan);

            if (side == 'left') {
                selected = this.startDate.clone();
                minDate = this.minDate;
            } else if (side == 'right') {
                selected = this.endDate.clone();
                minDate = this.startDate;

                //Preserve the time already selected
                var timeSelector = this.container.find('.drp-calendar.right .calendar-time');
                if (timeSelector.html() != '') {

                    selected.hour(!isNaN(selected.hour()) ? selected.hour() : timeSelector.find('.hourselect option:selected').val());
                    selected.minute(!isNaN(selected.minute()) ? selected.minute() : timeSelector.find('.minuteselect option:selected').val());
                    selected.second(!isNaN(selected.second()) ? selected.second() : timeSelector.find('.secondselect option:selected').val());

                    if (!this.timePicker24Hour) {
                        var ampm = timeSelector.find('.ampmselect option:selected').val();
                        if (ampm === 'PM' && selected.hour() < 12)
                            selected.hour(selected.hour() + 12);
                        if (ampm === 'AM' && selected.hour() === 12)
                            selected.hour(0);
                    }

                }

                if (selected.isBefore(this.startDate))
                    selected = this.startDate.clone();

                if (maxDate && selected.isAfter(maxDate))
                    selected = maxDate.clone();

            }

            //
            // hours
            //

            html = '<select class="hourselect">';

            var start = this.timePicker24Hour ? 0 : 1;
            var end = this.timePicker24Hour ? 23 : 12;

            for (var i = start; i <= end; i++) {
                var i_in_24 = i;
                if (!this.timePicker24Hour)
                    i_in_24 = selected.hour() >= 12 ? (i == 12 ? 12 : i + 12) : (i == 12 ? 0 : i);

                var time = selected.clone().hour(i_in_24);
                var disabled = false;
                if (minDate && time.minute(59).isBefore(minDate))
                    disabled = true;
                if (maxDate && time.minute(0).isAfter(maxDate))
                    disabled = true;

                if (i_in_24 == selected.hour() && !disabled) {
                    html += '<option value="' + i + '" selected="selected">' + i + '</option>';
                } else if (disabled) {
                    html += '<option value="' + i + '" disabled="disabled" class="disabled">' + i + '</option>';
                } else {
                    html += '<option value="' + i + '">' + i + '</option>';
                }
            }

            html += '</select> ';

            //
            // minutes
            //

            html += ': <select class="minuteselect">';

            for (var i = 0; i < 60; i += this.timePickerIncrement) {
                var padded = i < 10 ? '0' + i : i;
                var time = selected.clone().minute(i);

                var disabled = false;
                if (minDate && time.second(59).isBefore(minDate))
                    disabled = true;
                if (maxDate && time.second(0).isAfter(maxDate))
                    disabled = true;

                if (selected.minute() == i && !disabled) {
                    html += '<option value="' + i + '" selected="selected">' + padded + '</option>';
                } else if (disabled) {
                    html += '<option value="' + i + '" disabled="disabled" class="disabled">' + padded + '</option>';
                } else {
                    html += '<option value="' + i + '">' + padded + '</option>';
                }
            }

            html += '</select> ';

            //
            // seconds
            //

            if (this.timePickerSeconds) {
                html += ': <select class="secondselect">';

                for (var i = 0; i < 60; i++) {
                    var padded = i < 10 ? '0' + i : i;
                    var time = selected.clone().second(i);

                    var disabled = false;
                    if (minDate && time.isBefore(minDate))
                        disabled = true;
                    if (maxDate && time.isAfter(maxDate))
                        disabled = true;

                    if (selected.second() == i && !disabled) {
                        html += '<option value="' + i + '" selected="selected">' + padded + '</option>';
                    } else if (disabled) {
                        html += '<option value="' + i + '" disabled="disabled" class="disabled">' + padded + '</option>';
                    } else {
                        html += '<option value="' + i + '">' + padded + '</option>';
                    }
                }

                html += '</select> ';
            }

            //
            // AM/PM
            //

            if (!this.timePicker24Hour) {
                html += '<select class="ampmselect">';

                var am_html = '';
                var pm_html = '';

                if (minDate && selected.clone().hour(12).minute(0).second(0).isBefore(minDate))
                    am_html = ' disabled="disabled" class="disabled"';

                if (maxDate && selected.clone().hour(0).minute(0).second(0).isAfter(maxDate))
                    pm_html = ' disabled="disabled" class="disabled"';

                if (selected.hour() >= 12) {
                    html += '<option value="AM"' + am_html + '>AM</option><option value="PM" selected="selected"' + pm_html + '>PM</option>';
                } else {
                    html += '<option value="AM" selected="selected"' + am_html + '>AM</option><option value="PM"' + pm_html + '>PM</option>';
                }

                html += '</select>';
            }

            this.container.find('.drp-calendar.' + side + ' .calendar-time').html(html);

        },

        updateFormInputs: function() {

            if (this.singleDatePicker || (this.endDate && (this.startDate.isBefore(this.endDate) || this.startDate.isSame(this.endDate)))) {
                this.container.find('button.applyBtn').prop('disabled', false);
            } else {
                this.container.find('button.applyBtn').prop('disabled', true);
            }

        },

        move: function() {
            var parentOffset = { top: 0, left: 0 },
                containerTop,
                drops = this.drops;

            var parentRightEdge = $(window).width();
            if (!this.parentEl.is('body')) {
                parentOffset = {
                    top: this.parentEl.offset().top - this.parentEl.scrollTop(),
                    left: this.parentEl.offset().left - this.parentEl.scrollLeft()
                };
                parentRightEdge = this.parentEl[0].clientWidth + this.parentEl.offset().left;
            }

            switch (drops) {
            case 'auto':
                containerTop = this.element.offset().top + this.element.outerHeight() - parentOffset.top;
                if (containerTop + this.container.outerHeight() >= this.parentEl[0].scrollHeight) {
                    containerTop = this.element.offset().top - this.container.outerHeight() - parentOffset.top;
                    drops = 'up';
                }
                break;
            case 'up':
                containerTop = this.element.offset().top - this.container.outerHeight() - parentOffset.top;
                break;
            default:
                containerTop = this.element.offset().top + this.element.outerHeight() - parentOffset.top;
                break;
            }

            // Force the container to it's actual width
            this.container.css({
              top: 0,
              left: 0,
              right: 'auto'
            });
            var containerWidth = this.container.outerWidth();

            this.container.toggleClass('drop-up', drops == 'up');

            if (this.opens == 'left') {
                var containerRight = parentRightEdge - this.element.offset().left - this.element.outerWidth();
                if (containerWidth + containerRight > $(window).width()) {
                    this.container.css({
                        top: containerTop,
                        right: 'auto',
                        left: 9
                    });
                } else {
                    this.container.css({
                        top: containerTop,
                        right: containerRight,
                        left: 'auto'
                    });
                }
            } else if (this.opens == 'center') {
                var containerLeft = this.element.offset().left - parentOffset.left + this.element.outerWidth() / 2
                                        - containerWidth / 2;
                if (containerLeft < 0) {
                    this.container.css({
                        top: containerTop,
                        right: 'auto',
                        left: 9
                    });
                } else if (containerLeft + containerWidth > $(window).width()) {
                    this.container.css({
                        top: containerTop,
                        left: 'auto',
                        right: 0
                    });
                } else {
                    this.container.css({
                        top: containerTop,
                        left: containerLeft,
                        right: 'auto'
                    });
                }
            } else {
                var containerLeft = this.element.offset().left - parentOffset.left;
                if (containerLeft + containerWidth > $(window).width()) {
                    this.container.css({
                        top: containerTop,
                        left: 'auto',
                        right: 0
                    });
                } else {
                    this.container.css({
                        top: containerTop,
                        left: containerLeft,
                        right: 'auto'
                    });
                }
            }
        },

        show: function(e) {
            if (this.isShowing) return;

            // Create a click proxy that is private to this instance of datepicker, for unbinding
            this._outsideClickProxy = $.proxy(function(e) { this.outsideClick(e); }, this);

            // Bind global datepicker mousedown for hiding and
            $(document)
              .on('mousedown.daterangepicker', this._outsideClickProxy)
              // also support mobile devices
              .on('touchend.daterangepicker', this._outsideClickProxy)
              // also explicitly play nice with Bootstrap dropdowns, which stopPropagation when clicking them
              .on('click.daterangepicker', '[data-toggle=dropdown]', this._outsideClickProxy)
              // and also close when focus changes to outside the picker (eg. tabbing between controls)
              .on('focusin.daterangepicker', this._outsideClickProxy);

            // Reposition the picker if the window is resized while it's open
            $(window).on('resize.daterangepicker', $.proxy(function(e) { this.move(e); }, this));

            this.oldStartDate = this.startDate.clone();
            this.oldEndDate = this.endDate.clone();
            this.previousRightTime = this.endDate.clone();

            this.updateView();
            this.container.show();
            this.move();
            this.element.trigger('show.daterangepicker', this);
            this.isShowing = true;
        },

        hide: function(e) {
            if (!this.isShowing) return;

            //incomplete date selection, revert to last values
            if (!this.endDate) {
                this.startDate = this.oldStartDate.clone();
                this.endDate = this.oldEndDate.clone();
            }

            //if a new date range was selected, invoke the user callback function
            if (!this.startDate.isSame(this.oldStartDate) || !this.endDate.isSame(this.oldEndDate))
                this.callback(this.startDate.clone(), this.endDate.clone(), this.chosenLabel);

            //if picker is attached to a text input, update it
            this.updateElement();

            $(document).off('.daterangepicker');
            $(window).off('.daterangepicker');
            this.container.hide();
            this.element.trigger('hide.daterangepicker', this);
            this.isShowing = false;
        },

        toggle: function(e) {
            if (this.isShowing) {
                this.hide();
            } else {
                this.show();
            }
        },

        outsideClick: function(e) {
            var target = $(e.target);
            // if the page is clicked anywhere except within the daterangerpicker/button
            // itself then call this.hide()
            if (
                // ie modal dialog fix
                e.type == "focusin" ||
                target.closest(this.element).length ||
                target.closest(this.container).length ||
                target.closest('.calendar-table').length
                ) return;
            this.hide();
            this.element.trigger('outsideClick.daterangepicker', this);
        },

        showCalendars: function() {
            this.container.addClass('show-calendar');
            this.move();
            this.element.trigger('showCalendar.daterangepicker', this);
        },

        hideCalendars: function() {
            this.container.removeClass('show-calendar');
            this.element.trigger('hideCalendar.daterangepicker', this);
        },

        clickRange: function(e) {
            var label = e.target.getAttribute('data-range-key');
            this.chosenLabel = label;
            if (label == this.locale.customRangeLabel) {
                this.showCalendars();
            } else {
                var dates = this.ranges[label];
                this.startDate = dates[0];
                this.endDate = dates[1];

                if (!this.timePicker) {
                    this.startDate.startOf('day');
                    this.endDate.endOf('day');
                }

                if (!this.alwaysShowCalendars)
                    this.hideCalendars();
                this.clickApply();
            }
        },

        clickPrev: function(e) {
            var cal = $(e.target).parents('.drp-calendar');
            if (cal.hasClass('left')) {
                this.leftCalendar.month.subtract(1, 'month');
                if (this.linkedCalendars)
                    this.rightCalendar.month.subtract(1, 'month');
            } else {
                this.rightCalendar.month.subtract(1, 'month');
            }
            this.updateCalendars();
        },

        clickNext: function(e) {
            var cal = $(e.target).parents('.drp-calendar');
            if (cal.hasClass('left')) {
                this.leftCalendar.month.add(1, 'month');
            } else {
                this.rightCalendar.month.add(1, 'month');
                if (this.linkedCalendars)
                    this.leftCalendar.month.add(1, 'month');
            }
            this.updateCalendars();
        },

        hoverDate: function(e) {

            //ignore dates that can't be selected
            if (!$(e.target).hasClass('available')) return;

            var title = $(e.target).attr('data-title');
            var row = title.substr(1, 1);
            var col = title.substr(3, 1);
            var cal = $(e.target).parents('.drp-calendar');
            var date = cal.hasClass('left') ? this.leftCalendar.calendar[row][col] : this.rightCalendar.calendar[row][col];

            //highlight the dates between the start date and the date being hovered as a potential end date
            var leftCalendar = this.leftCalendar;
            var rightCalendar = this.rightCalendar;
            var startDate = this.startDate;
            if (!this.endDate) {
                this.container.find('.drp-calendar tbody td').each(function(index, el) {

                    //skip week numbers, only look at dates
                    if ($(el).hasClass('week')) return;

                    var title = $(el).attr('data-title');
                    var row = title.substr(1, 1);
                    var col = title.substr(3, 1);
                    var cal = $(el).parents('.drp-calendar');
                    var dt = cal.hasClass('left') ? leftCalendar.calendar[row][col] : rightCalendar.calendar[row][col];

                    if ((dt.isAfter(startDate) && dt.isBefore(date)) || dt.isSame(date, 'day')) {
                        $(el).addClass('in-range');
                    } else {
                        $(el).removeClass('in-range');
                    }

                });
            }

        },

        clickDate: function(e) {

            if (!$(e.target).hasClass('available')) return;

            var title = $(e.target).attr('data-title');
            var row = title.substr(1, 1);
            var col = title.substr(3, 1);
            var cal = $(e.target).parents('.drp-calendar');
            var date = cal.hasClass('left') ? this.leftCalendar.calendar[row][col] : this.rightCalendar.calendar[row][col];

            //
            // this function needs to do a few things:
            // * alternate between selecting a start and end date for the range,
            // * if the time picker is enabled, apply the hour/minute/second from the select boxes to the clicked date
            // * if autoapply is enabled, and an end date was chosen, apply the selection
            // * if single date picker mode, and time picker isn't enabled, apply the selection immediately
            // * if one of the inputs above the calendars was focused, cancel that manual input
            //

            if (this.endDate || date.isBefore(this.startDate, 'day')) { //picking start
                if (this.timePicker) {
                    var hour = parseInt(this.container.find('.left .hourselect').val(), 10);
                    if (!this.timePicker24Hour) {
                        var ampm = this.container.find('.left .ampmselect').val();
                        if (ampm === 'PM' && hour < 12)
                            hour += 12;
                        if (ampm === 'AM' && hour === 12)
                            hour = 0;
                    }
                    var minute = parseInt(this.container.find('.left .minuteselect').val(), 10);
                    if (isNaN(minute)) {
                        minute = parseInt(this.container.find('.left .minuteselect option:last').val(), 10);
                    }
                    var second = this.timePickerSeconds ? parseInt(this.container.find('.left .secondselect').val(), 10) : 0;
                    date = date.clone().hour(hour).minute(minute).second(second);
                }
                this.endDate = null;
                this.setStartDate(date.clone());
            } else if (!this.endDate && date.isBefore(this.startDate)) {
                //special case: clicking the same date for start/end,
                //but the time of the end date is before the start date
                this.setEndDate(this.startDate.clone());
            } else { // picking end
                if (this.timePicker) {
                    var hour = parseInt(this.container.find('.right .hourselect').val(), 10);
                    if (!this.timePicker24Hour) {
                        var ampm = this.container.find('.right .ampmselect').val();
                        if (ampm === 'PM' && hour < 12)
                            hour += 12;
                        if (ampm === 'AM' && hour === 12)
                            hour = 0;
                    }
                    var minute = parseInt(this.container.find('.right .minuteselect').val(), 10);
                    if (isNaN(minute)) {
                        minute = parseInt(this.container.find('.right .minuteselect option:last').val(), 10);
                    }
                    var second = this.timePickerSeconds ? parseInt(this.container.find('.right .secondselect').val(), 10) : 0;
                    date = date.clone().hour(hour).minute(minute).second(second);
                }
                this.setEndDate(date.clone());
                if (this.autoApply) {
                  this.calculateChosenLabel();
                  this.clickApply();
                }
            }

            if (this.singleDatePicker) {
                this.setEndDate(this.startDate);
                if (!this.timePicker && this.autoApply)
                    this.clickApply();
            }

            this.updateView();

            //This is to cancel the blur event handler if the mouse was in one of the inputs
            e.stopPropagation();

        },

        calculateChosenLabel: function () {
            var customRange = true;
            var i = 0;
            for (var range in this.ranges) {
              if (this.timePicker) {
                    var format = this.timePickerSeconds ? "YYYY-MM-DD HH:mm:ss" : "YYYY-MM-DD HH:mm";
                    //ignore times when comparing dates if time picker seconds is not enabled
                    if (this.startDate.format(format) == this.ranges[range][0].format(format) && this.endDate.format(format) == this.ranges[range][1].format(format)) {
                        customRange = false;
                        this.chosenLabel = this.container.find('.ranges li:eq(' + i + ')').addClass('active').attr('data-range-key');
                        break;
                    }
                } else {
                    //ignore times when comparing dates if time picker is not enabled
                    if (this.startDate.format('YYYY-MM-DD') == this.ranges[range][0].format('YYYY-MM-DD') && this.endDate.format('YYYY-MM-DD') == this.ranges[range][1].format('YYYY-MM-DD')) {
                        customRange = false;
                        this.chosenLabel = this.container.find('.ranges li:eq(' + i + ')').addClass('active').attr('data-range-key');
                        break;
                    }
                }
                i++;
            }
            if (customRange) {
                if (this.showCustomRangeLabel) {
                    this.chosenLabel = this.container.find('.ranges li:last').addClass('active').attr('data-range-key');
                } else {
                    this.chosenLabel = null;
                }
                this.showCalendars();
            }
        },

        clickApply: function(e) {
            this.hide();
            this.element.trigger('apply.daterangepicker', this);
        },

        clickCancel: function(e) {
            this.startDate = this.oldStartDate;
            this.endDate = this.oldEndDate;
            this.hide();
            this.element.trigger('cancel.daterangepicker', this);
        },

        monthOrYearChanged: function(e) {
            var isLeft = $(e.target).closest('.drp-calendar').hasClass('left'),
                leftOrRight = isLeft ? 'left' : 'right',
                cal = this.container.find('.drp-calendar.'+leftOrRight);

            // Month must be Number for new moment versions
            var month = parseInt(cal.find('.monthselect').val(), 10);
            var year = cal.find('.yearselect').val();

            if (!isLeft) {
                if (year < this.startDate.year() || (year == this.startDate.year() && month < this.startDate.month())) {
                    month = this.startDate.month();
                    year = this.startDate.year();
                }
            }

            if (this.minDate) {
                if (year < this.minDate.year() || (year == this.minDate.year() && month < this.minDate.month())) {
                    month = this.minDate.month();
                    year = this.minDate.year();
                }
            }

            if (this.maxDate) {
                if (year > this.maxDate.year() || (year == this.maxDate.year() && month > this.maxDate.month())) {
                    month = this.maxDate.month();
                    year = this.maxDate.year();
                }
            }

            if (isLeft) {
                this.leftCalendar.month.month(month).year(year);
                if (this.linkedCalendars)
                    this.rightCalendar.month = this.leftCalendar.month.clone().add(1, 'month');
            } else {
                this.rightCalendar.month.month(month).year(year);
                if (this.linkedCalendars)
                    this.leftCalendar.month = this.rightCalendar.month.clone().subtract(1, 'month');
            }
            this.updateCalendars();
        },

        timeChanged: function(e) {

            var cal = $(e.target).closest('.drp-calendar'),
                isLeft = cal.hasClass('left');

            var hour = parseInt(cal.find('.hourselect').val(), 10);
            var minute = parseInt(cal.find('.minuteselect').val(), 10);
            if (isNaN(minute)) {
                minute = parseInt(cal.find('.minuteselect option:last').val(), 10);
            }
            var second = this.timePickerSeconds ? parseInt(cal.find('.secondselect').val(), 10) : 0;

            if (!this.timePicker24Hour) {
                var ampm = cal.find('.ampmselect').val();
                if (ampm === 'PM' && hour < 12)
                    hour += 12;
                if (ampm === 'AM' && hour === 12)
                    hour = 0;
            }

            if (isLeft) {
                var start = this.startDate.clone();
                start.hour(hour);
                start.minute(minute);
                start.second(second);
                this.setStartDate(start);
                if (this.singleDatePicker) {
                    this.endDate = this.startDate.clone();
                } else if (this.endDate && this.endDate.format('YYYY-MM-DD') == start.format('YYYY-MM-DD') && this.endDate.isBefore(start)) {
                    this.setEndDate(start.clone());
                }
            } else if (this.endDate) {
                var end = this.endDate.clone();
                end.hour(hour);
                end.minute(minute);
                end.second(second);
                this.setEndDate(end);
            }

            //update the calendars so all clickable dates reflect the new time component
            this.updateCalendars();

            //update the form inputs above the calendars with the new time
            this.updateFormInputs();

            //re-render the time pickers because changing one selection can affect what's enabled in another
            this.renderTimePicker('left');
            this.renderTimePicker('right');

        },

        elementChanged: function() {
            if (!this.element.is('input')) return;
            if (!this.element.val().length) return;

            var dateString = this.element.val().split(this.locale.separator),
                start = null,
                end = null;

            if (dateString.length === 2) {
                start = moment(dateString[0], this.locale.format);
                end = moment(dateString[1], this.locale.format);
            }

            if (this.singleDatePicker || start === null || end === null) {
                start = moment(this.element.val(), this.locale.format);
                end = start;
            }

            if (!start.isValid() || !end.isValid()) return;

            this.setStartDate(start);
            this.setEndDate(end);
            this.updateView();
        },

        keydown: function(e) {
            //hide on tab or enter
            if ((e.keyCode === 9) || (e.keyCode === 13)) {
                this.hide();
            }

            //hide on esc and prevent propagation
            if (e.keyCode === 27) {
                e.preventDefault();
                e.stopPropagation();

                this.hide();
            }
        },

        updateElement: function() {
            if (this.element.is('input') && this.autoUpdateInput) {
                var newValue = this.startDate.format(this.locale.format);
                if (!this.singleDatePicker) {
                    newValue += this.locale.separator + this.endDate.format(this.locale.format);
                }
                if (newValue !== this.element.val()) {
                    this.element.val(newValue).trigger('change');
                }
            }
        },

        remove: function() {
            this.container.remove();
            this.element.off('.daterangepicker');
            this.element.removeData();
        }

    };

    $.fn.daterangepicker = function(options, callback) {
        var implementOptions = $.extend(true, {}, $.fn.daterangepicker.defaultOptions, options);
        this.each(function() {
            var el = $(this);
            if (el.data('daterangepicker'))
                el.data('daterangepicker').remove();
            el.data('daterangepicker', new DateRangePicker(el, implementOptions, callback));
        });
        return this;
    };

    return DateRangePicker;

}));


function swalDefault(title,html,icon){
    Swal.fire({
        title: title,
        html: html,
        icon: icon,
        confirmButtonText: "Selesai"
    })
}