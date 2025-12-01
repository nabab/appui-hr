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
              day = bbn.dt().weekday(i).get('date'),
              fullDay = bbn.dt().weekday(i).format('YYYY-MM-DD');
          if ( this.source.week ){
            let tmp = this.source.week.filter(ev => {
              let start = bbn.dt(ev.start).format('YYYY-MM-DD'),
                  end = bbn.dt(ev.end).format('YYYY-MM-DD');
              return (start <= fullDay) && (end >= fullDay);
            });
            if ( tmp.length ){
              color = bbn.fn.getField(this.card.absences, 'color', 'value', tmp[0].id_type)
            }
          }
          return {
            initials: bbn.dt().weekday(i).format('dd'),
            day: day,
            today: bbn.dt().weekday(i).get('date') === bbn.dt().get('date'),
            color: color
          }
        })
      });
    }
  }
})();