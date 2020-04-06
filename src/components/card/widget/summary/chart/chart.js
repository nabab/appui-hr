(() => {
  return {
    computed: {
      card(){
        return this.closest(`appui-hr-card`)
      },
      legend(){
        let leg = [];
        bbn.fn.iterate(this.source.summary, (v, i) => {
          leg.push(this.getText(i));
        });
        return leg;
      },
      colors(){
        let col = [];
        bbn.fn.iterate(this.source.summary, (v, i) => {
          col.push(this.getColor(i));
        });
        return col;
      },
      data(){
        let data = {
          labels: [],
          series: []
        };
        bbn.fn.iterate(this.source.summary, (v, i) => {
          data.labels.push(this.getText(i));
          data.series.push(v)
        });
        if ( !data.series.filter(s => s !== 0).length ){
          data.series = [];
        }
        return data;
      }
    },
    methods: {
      getText(id){
        return bbn.fn.get_field(appui.options.hr.absences, 'value', id, 'text');
      },
      getColor(id){
        return bbn.fn.get_field(appui.options.hr.absences, 'value', id, 'color');
      }
    }
  };
})();