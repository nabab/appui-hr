(() => {
  return {
    props: {
      yearMode: {
        type: Boolean,
        default: false
      }
    },
    data(){
      return {
        absences: appui.options.hr.absences,
        currentYear: bbn.date().format('YYYY'),
        selected: '',
        calendarSelected: false,
        events: [],
        isYearMode: this.yearMode,
        root: appui.plugins['appui-hr'] + '/',
        staff: appui.app.staffActive,
        currentStatus: null,
        hr: this.closest('appui-hr-main')
      }
    },
    computed: {
      card(){
        return this.closest(`appui-hr-card`)
      },
      dayText(){
        return this.selected ? bbn.date(this.selected).format('dddd	DD MMMM YYYY') : '';
      },
      calendars(){
        if ( this.isYearMode ){
          return this.findAll('bbn-calendar');
        }
        return [this.calendarSelected];
      },
      currentFilters(){
        let cond = [{
          field: 'id_staff',
          operator: '=',
          value: this.card.source.id
        }];
        if ( this.currentStatus ){
          cond.push({
            field: 'status',
            operator: '=',
            value: this.currentStatus
          });
        }
        return {
          logic: 'AND',
          conditions: cond
        }
      }
    },
    methods: {
      exportExcel(){
        this.postOut(this.root + 'actions/planning/excel', {
          start: this.calendarSelected.currentDate.format(bbn.fn.isFunction(this.calendarSelected.currentCfg.startFormat) ?
            this.calendarSelected.currentCfg.startFormat() :
            this.calendarSelected.currentCfg.startFormat
          ),
          end: this.calendarSelected.currentDate.format(bbn.fn.isFunction(this.calendarSelected.currentCfg.endFormat) ?
            this.calendarSelected.currentCfg.endFormat() :
            this.calendarSelected.currentCfg.endFormat
          ),
          filters: this.currentFilters
        })
      },
      changeSelected(val, cal){
        if  (val !== this.selected ){
          this.$set(this, 'selected', val);
        }
        if ( this.isYearMode ){
          this.calendarSelected = cal;
        }
      },
      addEvent(){
        this.getPopup({
          label: bbn._('Add'),
          height: 400,
          width: 600,
          component: 'appui-hr-form-event',
          source: {
            start: bbn.date(this.selected).format('YYYY-MM-DD HH:mm:ss'),
            end: bbn.date(this.selected).format('YYYY-MM-DD 23:59:59'),
            id_staff: this.card.source.id,
            id_type: '',
            note: '',
            status: 'accepted'
          },
          scrollable: false
        });
      },
      loadEvents(day){
        if ( (day === undefined) && this.selected ){
          day = this.selected;
        }
        if ( day ){
          this.post(this.root + 'data/events', {day: day}, (d) => {
            if ( d.data ){
              let list = this.getRef('events');
              this.$set(this, 'events', d.data);
              if ( list ){
                list.updateData();
              }
            }
          });
        }
      },
      fullRefresh(){
        this.loadEvents();
        this.calendarSelected.refresh();
      },
      getTitle(d) {
        let ret = '';
        if ( d.events && d.events.length ){
          bbn.fn.each(d.events, (e, i) => {
            ret += e.staff + ': ' + bbn.fn.getField(appui.options.hr.absences, 'text', 'value', e.id_type);
            if ( d.events[i + 1] ){
              ret += "\n";
            }
          });
        }
        return ret;
      },
      changeMode(cal){
        if ( cal ){
          this.changeSelected('', cal);
        }
        this.isYearMode = !this.isYearMode;
        if ( this.isYearMode ){
          this.calendarSelected = false;
        }
      },
      nextYear(){
        if ( this.isYearMode ){
          this.currentYear = bbn.date(this.currentYear).add(1, 'Y').format('YYYY');
          bbn.fn.each(this.calendars, c => c.next(true));
        }
      },
      prevYear(){
        if ( this.isYearMode ){
          this.currentYear = bbn.date(this.currentYear).subtract(1, 'Y').format('YYYY');
          bbn.fn.each(this.calendars, c => c.prev(true));
        }
      }
    },
    watch: {
      selected(newVal, oldVal){
        this.getRef('splitter').panes[1].collapsed = !newVal;
        if ( newVal ){
          this.loadEvents(newVal);
          if ( !oldVal && this.isYearMode ){
            this.$nextTick(() => {
              this.getRef('calendarContainer').find('bbn-scroll').onResize();
              this.getRef('calendarContainer').find('bbn-scroll').scrollSet(0, this.calendarSelected);
            });
          }
        }
        else {
          this.$set(this, 'events', []);
        }
      },
      /* calendarSelected(newVal, oldVal){
        if ( oldVal ){
          let o = oldVal._uid,
              n = false;
          if ( newVal ){
            n = newVal._uid;
          }
          if ( o !== n ){
            oldVal.$set(oldVal, 'selected', false);
          }
        }
      }, */
      yearMode(newVal){
        this.$set(this, 'isYearMode', newVal);
      },
      currentFilters:{
        deep: true,
        handler(newVal){
          let list = this.getRef('events');
          bbn.fn.each(this.calendars, (c) => {
            c.$set(c, 'currentFilters', newVal);
          });
          if ( list ){
            list.$set(list, 'currentFilters', newVal);
          }
        }
      }
    }
  }
})();