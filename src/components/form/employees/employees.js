(() => {
  return {
    props: ['source'],
    data(){
      return {
        tab: this.closest('bbn-container').getComponent()
      }
    },
    methods: {
      afterSubmit(d){
        if ( d.success ){
          if ( !this.source.row.id && d.data && d.data.id_employe ){
            appui.app.employees.push({
              text: this.source.row.surname + ' ' + this.source.row.name,
              value: d.data.id_employe,
              id_user: d.data.id_user
            });
          }
          else if ( this.source.row.id && d.data ){
            let idx = bbn.fn.search(appui.app.employees, 'value', this.source.row.id);
            if ( idx > -1 ){
              appui.$set(appui.app.employees[idx], 'text', this.source.row.surname + ' ' + this.source.row.name);
              appui.$set(appui.app.employees[idx], 'id_user', d.data.id_user);
            }

          }
          appui.app.employees = bbn.fn.order(appui.app.employees, 'text', 'ASC');
          appui.success(bbn._('Saved'));
          if ( this.tab.getRef('table') ){
            this.tab.getRef('table').updateData();
          }
        }
        else {
          appui.error(bbn._('Error'));
        }
      }
    }
  }
})();