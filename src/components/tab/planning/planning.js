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
        currentYear: moment().format('YYYY'),
        selected: '',
        calendarSelected: false,
        events: [],
        isYearMode: this.yearMode,
        lastEdit: '',
        isBefore: false,
        root: appui.plugins['appui-hr'] + '/'
      }
    },
    computed: {
      dayText(){
        return this.selected ? moment(this.selected).format('dddd	DD MMMM YYYY') : '';
      },
      calendars(){
        if ( this.isYearMode ){
          return this.findAll('bbn-calendar');
        }
        return [this.calendarSelected];
      }
    },
    methods: {
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
          this.post(this.root + 'data/planning/day', {day: day}, (d) => {
            if ( d.data ){
              d.data = d.data.map((e, i) => {
                e.hour = moment(e.end).diff(moment(e.start), 'minutes') / 60;
                e.nom = bbn.fn.get_field(appui.app.staff, 'value', e.id_employe, 'text');
                return e;
              });
              this.$set(this, 'events', d.data);
              this.$nextTick(() => {
                this.getRef('events').getRef('table').updateData();
              });
            }
            else {
              this.$set(this, 'events', []);
              this.$nextTick(() => {
                if ( this.getRef('events') ){
                  this.getRef('events').getRef('table').updateData();
                }
              });
            }
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
        if ( d.events && d.events.length ){
          bbn.fn.each(d.events, (e, i) => {
            let idx = bbn.fn.search(tmp, 'id', e.id_employe);
            if ( idx === -1 ){
              tmp.push({
                id: e.id_employe,
                nom: bbn.fn.get_field(appui.app.staff, 'value', e.id_employe, 'text'),
                hour: moment(e.end).diff(moment(e.start), 'minutes')
              });
            }
            else {
              tmp[idx].hour += moment(e.end).diff(moment(e.start), 'minutes');
            }
          });
          tmp = bbn.fn.order(tmp, 'nom', 'ASC');
          bbn.fn.each(tmp, (t, i) => {
            ret += t.nom + ': ' + t.hour/60;
            if ( tmp[i + 1] ){
              ret += "\n";
            }
          });
        }
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
          this.currentYear = moment(this.currentYear, 'YYYY').add(1, 'Y').format('YYYY');
          bbn.fn.each(this.calendars, c => c.next(true));
        }
      },
      prevYear(){
        if ( this.isYearMode ){
          this.currentYear = moment(this.currentYear, 'YYYY').subtract(1, 'Y').format('YYYY');
          bbn.fn.each(this.calendars, c => c.prev(true));
        }
      },
      afterLoadDays(d){
        if ( d.success ){
          let cal = this.getRef('calendar')
          cal.$set(cal.data, 'force', false);
          this.$set(this, 'lastEdit', '');
        }
      },
      setIsBefore(ev, cal){
        this.$set(this, 'isBefore', !!moment(cal.currentDate.format('YYYY-MM-01')).isBefore(moment().format('YYYY-MM-01')));
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
              this.getRef('calendarContainer').find('bbn-scroll').scrollTo(0, this.calendarSelected);              
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
      }
    }
  }
})();