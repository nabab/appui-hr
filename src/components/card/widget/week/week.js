(() => {
  return {
    data(){
      return {
        days: []
      }
    },
    computed: {
      card(){
        return this.closest(`appui-hr-card`)
      }
    },
    mounted(){
      this.$nextTick(() => {
        this.days = Array.from({length: 7}, (v, i) => {
          let color = false,
              day = moment().weekday(i).get('date'),
              fullDay = moment().weekday(i).format('YYYY-MM-DD');
          if ( this.source.week ){
            let tmp = this.source.week.filter(ev => {
              let start = moment(ev.start).format('YYYY-MM-DD'),
                  end = moment(ev.end).format('YYYY-MM-DD');
              return (start <= fullDay) && (end >= fullDay);
            });
            if ( tmp.length ){
              color = bbn.fn.get_field(this.card.absences, 'value', tmp[0].id_type, 'color')
            }
          }
          return {
            initials: moment().weekday(i).format('dd'),
            day: day,
            today: moment().weekday(i).get('date') === moment().get('date'),
            color: color
          }
        })
      });
    }
  }
})();