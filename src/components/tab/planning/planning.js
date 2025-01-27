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
        currentYear: dayjs().format('YYYY'),
        selected: '',
        calendarSelected: false,
        events: [],
        isYearMode: this.yearMode,
        root: appui.plugins['appui-hr'] + '/',
        staff: appui.app.staffActive,
        currentStaff: null,
        isLoading: false
      }
    },
    computed: {
      hr(){
        return this.closest('appui-hr-main');
      },
      dayText(){
        return this.selected ? dayjs(this.selected).format('dddd	DD MMMM YYYY') : '';
      },
      calendars(){
        if ( this.isYearMode ){
          return this.findAll('bbn-calendar');
        }
        return [this.calendarSelected];
      },
      currentFilters(){
        return {
          logic: 'AND',
          conditions: this.currentStaff ? [{
            field: 'id_staff',
            operator: '=',
            value: this.currentStaff
          }] : []
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
        this.$set(this, 'selected', val);
        if ( this.isYearMode ){
          this.calendarSelected = cal;
        }
      },
      addEvent(){
        this.getRef('events').add();
      },
      loadEvents(day){
        if ( (day === undefined) && this.selected ){
          day = this.selected;
        }
        if ( day ){
          this.isLoading = true;
          this.post(this.root + 'data/planning/day', {day: day, filters: this.currentFilters}, (d) => {
            if ( d.data ){
              d.data = d.data.map((e, i) => {
                e.hour = dayjs(e.end).diff(dayjs(e.start), 'minutes') / 60;
                e.nom = bbn.fn.getField(appui.app.staffActive, 'text', 'value', e.id_staff);
                return e;
              });
              this.$set(this, 'events', d.data);
            }
            else {
              this.$set(this, 'events', []);
            }
            this.isLoading = false;
            this.$nextTick(() => {
              if ( this.getRef('events') ){
                this.getRef('events').getRef('table').updateData();
              }
            });
          }, () => {
            this.isLoading = false;
          });
        }
      },
      fullRefresh(){
        this.loadEvents();
        this.calendarSelected.refresh();
      },
      getTitle(d) {
        let ret = '',
            tmp = [];
        /* if ( d.events && d.events.length ){
          bbn.fn.each(d.events, (e, i) => {
            let idx = bbn.fn.search(tmp, 'id', e.id_staff);
            if ( idx === -1 ){
              tmp.push({
                id: e.id_staff,
                name: bbn.fn.getField(appui.app.staffActive, 'text', 'value', e.id_staff),
                hour: dayjs(e.end).diff(dayjs(e.start), 'minutes')
              });
            }
            else {
              tmp[idx].hour += dayjs(e.end).diff(dayjs(e.start), 'minutes');
            }
          });
          tmp = bbn.fn.order(tmp, 'name', 'ASC');
          bbn.fn.each(tmp, (t, i) => {
            ret += t.name + ': ' + t.hour/60;
            if ( tmp[i + 1] ){
              ret += "\n";
            }
          });
        } */
        return ret;
      },
      changeMode(cal){
        if ( cal ){
          this.changeSelected(false, cal);
        }
        this.isYearMode = !this.isYearMode;
        if ( this.isYearMode ){
          this.calendarSelected = false;
        }
      },
      nextYear(){
        if ( this.isYearMode ){
          this.currentYear = dayjs(this.currentYear, 'YYYY').add(1, 'Y').format('YYYY');
          bbn.fn.each(this.calendars, c => c.next(true));
        }
      },
      prevYear(){
        if ( this.isYearMode ){
          this.currentYear = dayjs(this.currentYear, 'YYYY').subtract(1, 'Y').format('YYYY');
          bbn.fn.each(this.calendars, c => c.prev(true));
        }
      }
    },
    watch: {
      selected(newVal, oldVal){
        bbn.fn.each(this.calendars, (c) => {
          c.$set(c, 'currentValue', newVal);
        });
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
          this.$nextTick(() => {
            if ( this.getRef('events') ){
              this.getRef('events').getRef('table').updateData();
            }
          });
        }
      },
      calendarSelected(newVal, oldVal){
        if ( oldVal ){
          let o = oldVal._uid,
              n = false;
          if ( newVal ){
            n = newVal._uid;
          }
          if ( o !== n ){
            oldVal.$set(oldVal, 'currentValue', false);
          }
        }
      },
      yearMode(newVal){
        this.$set(this, 'isYearMode', newVal);
      },
      currentFilters(newVal){
        let table = this.getRef('events').getRef('table');
        bbn.fn.each(this.calendars, (c) => {
          c.$set(c, 'currentFilters', newVal);
        });
        if ( table ){
          table.$set(table, 'currentFilters', newVal);
        }
      }
    }
  }
})();