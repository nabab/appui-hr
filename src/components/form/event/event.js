(() => {
  return {
    data(){
      return {
        absences: bbn.fn.order(appui.options.hr.absences, 'text', 'ASC'),
        staff: appui.app.staff,
        root: appui.plugins['appui-hr'] + '/'
      }
    },
    computed: {
      planning(){
        return this.closest('bbn-container').find('appui-hr-tab-holidays-planning');
      }
    },
    methods: {
      afterSubmit(d){
        if ( d.success ){
          appui.success(bbn._('Saved'));
          this.planning.fullRefresh();          
        }
        else {
          appui.error();
        }
      }
    }
  }
})();
