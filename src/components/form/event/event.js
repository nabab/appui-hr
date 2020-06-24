(() => {
  return {
    data(){
      return {
        absences: bbn.fn.order(appui.options.hr.absences, 'text', 'ASC'),
        staff: appui.app.staffActive,
        root: appui.plugins['appui-hr'] + '/',
        hr: this.closest('appui-hr-main')
      }
    },
    computed: {
      planning(){
        return this.closest('bbn-container').find('appui-hr-tab-holidays-planning');
      },
      card(){
        return this.closest('bbn-container').find('appui-hr-card-tab-holidays-planning');
      }
    },
    methods: {
      afterSubmit(d){
        if ( d.success ){
          appui.success(bbn._('Saved'));
          if ( this.planning ){
            this.planning.fullRefresh();
          }
          if ( this.card ){
            this.card.fullRefresh();
          }
        }
        else {
          appui.error();
        }
      }
    }
  }
})();
