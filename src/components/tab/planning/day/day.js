(() => {
  return {
    props: {
      source: {
        type: Object
      }
    },
    computed: {
      employes(){
        let res = [];
        if ( this.source.events && this.source.events.length ){
          bbn.fn.each(this.source.events, e => {
            let n = this.getEmploye(e.id_employe)
            if ( !res.includes(n) ){
              res.push(n)
            }
          });
        }
        return res.sort()
      }
    },
    methods: {
      getEmploye(id){
        return bbn.fn.get_field(appui.app.staff, {value: id}, 'text')
      }
    }
  }
})();