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
        currentYear: moment().format('YYYY'),
        selected: '',
        calendarSelected: false,
        events: [],
        isYearMode: this.yearMode
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
        this.getPopup().open({
          title: bbn._('Ajouter'),
          height: 400,
          width: 600,
          component: 'ami-hr-form-event',
          source: {
            start: moment(this.selected).format('YYYY-MM-DD HH:mm:ss'),
            end: moment(this.selected).format('YYYY-MM-DD 23:59:59'),
            id_employe: '',
            id_type: '',
            note: ''
          }
        });
      },
      loadEvents(day){
        if ( (day === undefined) && this.selected ){
          day = this.selected;
        }
        if ( day ){
          this.post('data/hr/events', {day: day}, (d) => {
            if ( d.data ){
              this.$set(this, 'events', d.data);
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
            ret += e.employe + ': ' + bbn.fn.get_field(appui.options.hr.absences, 'value', e.id_type, 'text');
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
          this.currentYear = moment(this.currentYear).add(1, 'Y').format('YYYY');
          bbn.fn.each(this.calendars, c => c.next(true));
        }
      },
      prevYear(){
        if ( this.isYearMode ){
          this.currentYear = moment(this.currentYear).subtract(1, 'Y').format('YYYY');
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
              this.getRef('calendarContainer').find('bbn-scroll').scrollTo(0, this.calendarSelected);              
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
      }
    }
  }
})();