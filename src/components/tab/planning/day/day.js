(() => {
  return {
    props: {
      source: {
        type: Object
      }
    },
    computed: {
      staff(){
        let ret = [],
            tmp = [];
        if ( this.source.events && this.source.events.length ){
          bbn.fn.each(this.source.events, (e, i) => {
            let idx = bbn.fn.search(tmp, 'id', e.id_staff);
            if ( idx === -1 ){
              tmp.push({
                id: e.id_staff,
                name: bbn.fn.getField(appui.app.staffActive, 'text', 'value', e.id_staff),
                hour: moment(e.end).diff(moment(e.start), 'minutes')
              });
            }
            else {
              tmp[idx].hour += moment(e.end).diff(moment(e.start), 'minutes');
            }
          });
          tmp = bbn.fn.order(tmp, 'name', 'ASC');
          bbn.fn.each(tmp, (t, i) => {
            ret.push(t.name + ': ' + t.hour/60);
          });
        }
        return ret;
      }
    }
  }
})();