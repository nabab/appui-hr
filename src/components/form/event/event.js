(() => {
  return {
    data(){
      return {
        absences: bbn.fn.order(appui.options.hr.absences, 'text', 'ASC'),
        employees: appui.app.staff,
        planning: false
      }
    },
    methods: {
      afterSubmit(d){
        if ( d.success ){
          appui.success(bbn._('Enregistré'));
          this.planning.fullRefresh();          
        }
        else {
          appui.error();
        }
      }
    },
    mounted(){
      this.planning = this.closest('bbn-container').find('ami-hr-tab-holidays-planning');
    }
  }
})();
