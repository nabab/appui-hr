(() => {
  return {
    data(){
      return {
        employes: appui.app.employees.filter( e => e.value !== this.source.id_old_employe)
      }
    },
    methods: {
      afterSubmit(d){
        if ( d.success ){
          this.closest('bbn-container').getComponent().getRef('table').updateData();
          appui.success(bbn._('Enregistré'));
        }
        else {
          appui.error();
        }
      }
    }
  };
})();