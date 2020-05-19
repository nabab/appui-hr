(() => {
  return {
    data(){
      return {
        group: false 
      }
    },
    computed: {
      card(){
        return this.closest(`appui-hr-card`)
      },
      absenceText(){
        if ( this.source.today.length ){
          let txt = bbn.fn.getField(this.card.absences, 'text', 'value', this.source.today[0].id_type).toUpperCase(),
              start = moment(this.source.today[0].start).format('DD/MM/YYYY'),
              end = moment(this.source.today[0].end).format('DD/MM/YYYY');
          return `
            <div class="bbn-large">${txt}</div>
            <div>${start} <i class="nf nf-fa-long_arrow_right"></i> ${end}</div>
          `;
        }
        return '<span class="bbn-large">' + bbn._('PRESENT') + '</span>';
      },
      absenceColor(){
        if (this.source.today.length){
          return bbn.fn.getField(this.card.absences, 'color', 'value', this.source.today[0].id_type);
        }
        return 'yellowgreen';
      }
    },
    methods: {
      fdate: bbn.fn.fdate
    },
    mounted(){
      if ( this.card.idGroup ){
        this.group = bbn.fn.getField(appui.app.groups, 'group', 'id', this.card.idGroup).toUpperCase()
      }
    }
  }
})();