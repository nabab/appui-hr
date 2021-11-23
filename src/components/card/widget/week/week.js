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
              day = dayjs().weekday(i).get('date'),
              fullDay = dayjs().weekday(i).format('YYYY-MM-DD');
          if ( this.source.week ){
            let tmp = this.source.week.filter(ev => {
              let start = dayjs(ev.start).format('YYYY-MM-DD'),
                  end = dayjs(ev.end).format('YYYY-MM-DD');
              return (start <= fullDay) && (end >= fullDay);
            });
            if ( tmp.length ){
              color = bbn.fn.getField(this.card.absences, 'color', 'value', tmp[0].id_type)
            }
          }
          return {
            initials: dayjs().weekday(i).format('dd'),
            day: day,
            today: dayjs().weekday(i).get('date') === dayjs().get('date'),
            color: color
          }
        })
      });
    }
  }
})();