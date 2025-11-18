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
              day = bbn.date().weekday(i).get('date'),
              fullDay = bbn.date().weekday(i).format('YYYY-MM-DD');
          if ( this.source.week ){
            let tmp = this.source.week.filter(ev => {
              let start = bbn.date(ev.start).format('YYYY-MM-DD'),
                  end = bbn.date(ev.end).format('YYYY-MM-DD');
              return (start <= fullDay) && (end >= fullDay);
            });
            if ( tmp.length ){
              color = bbn.fn.getField(this.card.absences, 'color', 'value', tmp[0].id_type)
            }
          }
          return {
            initials: bbn.date().weekday(i).format('dd'),
            day: day,
            today: bbn.date().weekday(i).get('date') === bbn.date().get('date'),
            color: color
          }
        })
      });
    }
  }
})();